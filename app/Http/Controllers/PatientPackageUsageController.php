<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\PatientPackage;
use App\Models\PatientPackageUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientPackageUsageController extends Controller
{
    /**
     * Display a listing of package usages.
     */
    public function index(Request $request)
    {
        $query = PatientPackageUsage::with([
            'patientPackage.patient',
            'patientPackage.servicePackage',
            'servicePackageDetail.serviceRate',
            'appointment',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->whereHas(
                    'patientPackage',
                    function ($q) use ($search) {

                        $q->where(
                            'patient_package_no',
                            'like',
                            "%{$search}%"
                        );

                        $q->orWhereHas(
                            'patient',
                            function ($q) use ($search) {

                                $q->where(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                );

                            }
                        );

                    }
                );

                $q->orWhereHas(
                    'servicePackageDetail.serviceRate',
                    function ($q) use ($search) {

                        $q->where(
                            'service_name',
                            'like',
                            "%{$search}%"
                        );

                    }
                );

                $q->orWhereHas(
                    'appointment',
                    function ($q) use ($search) {

                        $q->where(
                            'appointment_no',
                            'like',
                            "%{$search}%"
                        );

                    }
                );

            });
        }


        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('used_at')) {

            $query->whereDate(
                'used_at',
                $request->used_at
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $usages = $query
            ->latest('used_at')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();


        return view(
            'patient_package_usages.index',
            compact('usages')
        );
    }


    /**
     * Show the form for creating a new usage.
     */
public function create(Request $request)
{
    $patientPackages = PatientPackage::where(
        'status',
        PatientPackage::STATUS_ACTIVE
    )
        ->with([
            'patient',
            'servicePackage.details.serviceRate',
            'usages',
        ])
        ->orderBy('patient_package_no')
        ->get();

    $appointments = Appointment::with([
        'patient',
        'branch',
        'serviceRate',
    ])
        ->whereNotIn('status', [
            Appointment::STATUS_CANCELLED,
            Appointment::STATUS_NO_SHOW,
        ])
        ->latest('appointment_date')
        ->latest('appointment_time')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Siapkan data Patient Package untuk JavaScript
    |--------------------------------------------------------------------------
    */

    $packageData = $patientPackages->map(
        function ($patientPackage) {

            return [

                'id' =>
                    $patientPackage->id,

                'package_no' =>
                    $patientPackage->patient_package_no,

                'patient_name' =>
                    $patientPackage->patient->name,

                'package_name' =>
                    $patientPackage
                        ->servicePackage
                        ->package_name,

                'status_label' =>
                    $patientPackage
                        ->status_label,

                'details' =>
                    $patientPackage
                        ->servicePackage
                        ->details
                        ->map(
                            function ($detail) use (
                                $patientPackage
                            ) {

                                $used =
                                    $patientPackage
                                        ->usages
                                        ->where(
                                            'service_package_detail_id',
                                            $detail->id
                                        )
                                        ->sum('quantity');

                                $remaining =
                                    max(
                                        0,
                                        $detail->quantity - $used
                                    );

                                return [

                                    'id' =>
                                        $detail->id,

                                    'service_name' =>
                                        $detail
                                            ->serviceRate
                                            ->service_name,

                                    'quota' =>
                                        $detail->quantity,

                                    'used' =>
                                        $used,

                                    'remaining' =>
                                        $remaining,

                                    'price' =>
                                        $detail->price,

                                ];
                            }
                        )
                        ->values(),

            ];
        }
    )->values();

    $selectedPatientPackage =
        $request->patient_package_id;

    return view(
        'patient_package_usages.create',
        compact(
            'patientPackages',
            'appointments',
            'selectedPatientPackage',
            'packageData'
        )
    );
}


    /**
     * Store a newly created usage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'patient_package_id' => [
                'required',
                'exists:patient_packages,id',
            ],

            'service_package_detail_id' => [
                'required',
                'exists:service_package_details,id',
            ],

            'appointment_id' => [
                'nullable',
                'exists:appointments,id',
            ],

            'used_at' => [
                'required',
                'date',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Business Rule
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use ($validated) {

            /*
            |--------------------------------------------------------------------------
            | Lock Patient Package
            |--------------------------------------------------------------------------
            */

            $patientPackage = PatientPackage::with([
                'servicePackage.details',
                'usages',
            ])
                ->lockForUpdate()
                ->findOrFail(
                    $validated['patient_package_id']
                );


            /*
            |--------------------------------------------------------------------------
            | Package Must Be Active
            |--------------------------------------------------------------------------
            */

            if (
                $patientPackage->status
                !== PatientPackage::STATUS_ACTIVE
            ) {

                abort(
                    422,
                    'Patient Package tidak dalam status Aktif.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Find Package Detail
            |--------------------------------------------------------------------------
            */

            $detail =
                $patientPackage
                    ->servicePackage
                    ->details
                    ->firstWhere(
                        'id',
                        $validated[
                            'service_package_detail_id'
                        ]
                    );


            if (!$detail) {

                abort(
                    422,
                    'Service tidak termasuk dalam Patient Package.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Calculate Already Used
            |--------------------------------------------------------------------------
            */

            $usedQuantity =
                $patientPackage->usages
                    ->where(
                        'service_package_detail_id',
                        $detail->id
                    )
                    ->sum('quantity');


            /*
            |--------------------------------------------------------------------------
            | Calculate Remaining
            |--------------------------------------------------------------------------
            */

            $remainingQuantity =
                $detail->quantity
                - $usedQuantity;


            /*
            |--------------------------------------------------------------------------
            | Check Remaining
            |--------------------------------------------------------------------------
            */

            if (
                $validated['quantity']
                > $remainingQuantity
            ) {

                abort(
                    422,
                    "Kuota tidak mencukupi. Sisa kuota layanan ini: {$remainingQuantity}."
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Create Usage
            |--------------------------------------------------------------------------
            */

            PatientPackageUsage::create([

                'patient_package_id' =>
                    $patientPackage->id,

                'service_package_detail_id' =>
                    $detail->id,

                'appointment_id' =>
                    $validated['appointment_id'] ?? null,

                'used_at' =>
                    $validated['used_at'],

                'quantity' =>
                    $validated['quantity'],

                'price' =>
                    $validated['price'] ?? null,

                'notes' =>
                    $validated['notes'] ?? null,

            ]);


            /*
            |--------------------------------------------------------------------------
            | Check Whether Package Is Completed
            |--------------------------------------------------------------------------
            */

            $allDetailsCompleted = true;

            foreach (
                $patientPackage
                    ->servicePackage
                    ->details
                as $packageDetail
            ) {

                $used =
                    $patientPackage->usages
                        ->where(
                            'service_package_detail_id',
                            $packageDetail->id
                        )
                        ->sum('quantity');


                /*
                |--------------------------------------------------------------------------
                | Include Newly Created Usage
                |--------------------------------------------------------------------------
                */

                if (
                    $packageDetail->id
                    === $detail->id
                ) {

                    $used +=
                        $validated['quantity'];

                }


                if (
                    $used
                    < $packageDetail->quantity
                ) {

                    $allDetailsCompleted = false;

                    break;

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Update Package Status
            |--------------------------------------------------------------------------
            */

            if ($allDetailsCompleted) {

                $patientPackage->update([

                    'status' =>
                        PatientPackage::STATUS_COMPLETED,

                ]);

            }

        });


        return redirect()
            ->route(
                'patient_package_usages.index'
            )
            ->with(
                'success',
                'Pemakaian paket berhasil dicatat.'
            );
    }


    /**
     * Display the specified usage.
     */
    public function show(
        PatientPackageUsage $patientPackageUsage
    ) {

        $patientPackageUsage->load([

            'patientPackage.patient',

            'patientPackage.servicePackage',

            'servicePackageDetail.serviceRate',

            'appointment.branch',

            'appointment.psychologist',

        ]);


        return view(
            'patient_package_usages.show',
            compact(
                'patientPackageUsage'
            )
        );
    }


    /**
     * Edit usage.
     */
    public function edit(
        PatientPackageUsage $patientPackageUsage
    ) {

        $patientPackageUsage->load([
            'patientPackage.patient',
            'patientPackage.servicePackage.details.serviceRate',
            'patientPackage.usages',
            'servicePackageDetail.serviceRate',
        ]);


        return view(
            'patient_package_usages.edit',
            compact(
                'patientPackageUsage'
            )
        );
    }


    /**
     * Update usage.
     */
    public function update(
        Request $request,
        PatientPackageUsage $patientPackageUsage
    ) {

        $validated = $request->validate([

            'used_at' => [
                'required',
                'date',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

        ]);


        DB::transaction(function () use (
            $validated,
            $patientPackageUsage
        ) {

            $patientPackage =
                PatientPackage::with([
                    'servicePackage.details',
                    'usages',
                ])
                    ->lockForUpdate()
                    ->findOrFail(
                        $patientPackageUsage
                            ->patient_package_id
                    );


            $detail =
                $patientPackage
                    ->servicePackage
                    ->details
                    ->firstWhere(
                        'id',
                        $patientPackageUsage
                            ->service_package_detail_id
                    );


            if (!$detail) {

                abort(
                    422,
                    'Service package detail tidak ditemukan.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Exclude Current Usage
            |--------------------------------------------------------------------------
            */

            $usedOtherQuantity =
                $patientPackage->usages
                    ->where(
                        'service_package_detail_id',
                        $detail->id
                    )
                    ->where(
                        'id',
                        '!=',
                        $patientPackageUsage->id
                    )
                    ->sum('quantity');


            /*
            |--------------------------------------------------------------------------
            | Remaining For Update
            |--------------------------------------------------------------------------
            */

            $remainingQuantity =
                $detail->quantity
                - $usedOtherQuantity;


            if (
                $validated['quantity']
                > $remainingQuantity
            ) {

                abort(
                    422,
                    "Kuota tidak mencukupi. Maksimal quantity yang dapat digunakan: {$remainingQuantity}."
                );

            }


            $patientPackageUsage->update([

                'used_at' =>
                    $validated['used_at'],

                'quantity' =>
                    $validated['quantity'],

                'price' =>
                    $validated['price'] ?? null,

                'notes' =>
                    $validated['notes'] ?? null,

            ]);


            /*
            |--------------------------------------------------------------------------
            | Recalculate Package Status
            |--------------------------------------------------------------------------
            */

            $allDetailsCompleted = true;


            foreach (
                $patientPackage
                    ->servicePackage
                    ->details
                as $packageDetail
            ) {

                $used =
                    $patientPackage->usages
                        ->where(
                            'service_package_detail_id',
                            $packageDetail->id
                        )
                        ->sum('quantity');


                /*
                |--------------------------------------------------------------------------
                | Current Usage Still Has Old Quantity
                |--------------------------------------------------------------------------
                */

                if (
                    $packageDetail->id
                    === $detail->id
                ) {

                    $used -=
                        $patientPackageUsage
                            ->getOriginal('quantity');

                    $used +=
                        $validated['quantity'];

                }


                if (
                    $used
                    < $packageDetail->quantity
                ) {

                    $allDetailsCompleted = false;

                    break;

                }

            }


            $patientPackage->update([

                'status' =>
                    $allDetailsCompleted
                        ? PatientPackage::STATUS_COMPLETED
                        : PatientPackage::STATUS_ACTIVE,

            ]);

        });


        return redirect()
            ->route(
                'patient_package_usages.show',
                $patientPackageUsage
            )
            ->with(
                'success',
                'Pemakaian paket berhasil diperbarui.'
            );
    }


    /**
     * Remove usage.
     *
     * Usage is intentionally not soft-deleted.
     * For now this method is disabled.
     */
    public function destroy(
        PatientPackageUsage $patientPackageUsage
    ) {

        abort(
            422,
            'Pemakaian paket tidak dapat dihapus. Gunakan mekanisme koreksi/void.'
        );
    }
}