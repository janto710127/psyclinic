<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientPackage;
use App\Models\PatientPackageUsage;
use App\Models\ServicePackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientPackageController extends Controller
{
    /**
     * Display a listing of patient packages.
     */
    public function index(Request $request)
    {
        $query = PatientPackage::with([
            'patient',
            'servicePackage',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('patient_package_no', 'like', "%{$search}%")
                    ->orWhereHas('patient', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('servicePackage', function ($q) use ($search) {
                        $q->where('package_name', 'like', "%{$search}%");
                    });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('purchased_at')) {
            $query->whereDate(
                'purchased_at',
                $request->purchased_at
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $patientPackages = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        $summary = [
            'total' => PatientPackage::count(),

            'active' => PatientPackage::where(
                'status',
                PatientPackage::STATUS_ACTIVE
            )->count(),

            'completed' => PatientPackage::where(
                'status',
                PatientPackage::STATUS_COMPLETED
            )->count(),

            'expired' => PatientPackage::where(
                'status',
                PatientPackage::STATUS_EXPIRED
            )->count(),

            'cancelled' => PatientPackage::where(
                'status',
                PatientPackage::STATUS_CANCELLED
            )->count(),
        ];

        return view(
            'patient_packages.index',
            compact(
                'patientPackages',
                'summary'
            )
        );
    }

    /**
     * Show the form for creating a new patient package.
     */
public function create()
{
    $patients = Patient::orderBy('name')
        ->get();

    $servicePackages = ServicePackage::where('is_active', true)
        ->with('details.serviceRate')
        ->orderBy('package_name')
        ->get();

    $packageData = $servicePackages->map(function ($package) {
        return [
            'id' => $package->id,
            'price' => $package->price,
            'validity_days' => $package->validity_days,
            'details' => $package->details->map(function ($detail) {
                return [
                    'service_name' => $detail->serviceRate->service_name,
                    'quantity' => $detail->quantity,
                    'price' => $detail->price,
                ];
            })->values(),
        ];
    })->values();

    return view(
        'patient_packages.create',
        compact(
            'patients',
            'servicePackages',
            'packageData'
        )
    );
}

    /**
     * Store a newly created patient package.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => [
                'required',
                'exists:patients,id',
            ],

            'service_package_id' => [
                'required',
                'exists:service_packages,id',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'purchased_at' => [
                'required',
                'date',
            ],

            'started_at' => [
                'nullable',
                'date',
                'after_or_equal:purchased_at',
            ],

            'expired_at' => [
                'nullable',
                'date',
                'after_or_equal:started_at',
            ],

            'status' => [
                'required',
                'integer',
                'in:1,2,3,4',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        DB::transaction(function () use ($validated) {

            /*
            |--------------------------------------------------------------------------
            | Generate Patient Package Number
            |--------------------------------------------------------------------------
            */

            $lastId = PatientPackage::withTrashed()
                ->max('id');

            $nextNumber = ($lastId ?? 0) + 1;

            $patientPackageNo = 'PPK' .
                str_pad(
                    $nextNumber,
                    4,
                    '0',
                    STR_PAD_LEFT
                );

            /*
            |--------------------------------------------------------------------------
            | Get Service Package
            |--------------------------------------------------------------------------
            */

            $servicePackage = ServicePackage::where(
                'is_active',
                true
            )->findOrFail(
                $validated['service_package_id']
            );

            /*
            |--------------------------------------------------------------------------
            | Create Patient Package
            |--------------------------------------------------------------------------
            */

            PatientPackage::create([
                'patient_package_no' => $patientPackageNo,

                'patient_id' => $validated['patient_id'],

                'service_package_id' =>
                    $validated['service_package_id'],

                /*
                 * Snapshot harga package.
                 */
                'price' => $validated['price'],

                'purchased_at' =>
                    $validated['purchased_at'],

                'started_at' =>
                    $validated['started_at'] ?? null,

                'expired_at' =>
                    $validated['expired_at'] ?? null,

                'status' =>
                    $validated['status'],

                'notes' =>
                    $validated['notes'] ?? null,
            ]);
        });

        return redirect()
            ->route('patient_packages.index')
            ->with(
                'success',
                'Patient Package berhasil dibuat.'
            );
    }


public function byPatient(Patient $patient)
{
    $patientPackages = PatientPackage::query()
        ->where('patient_id', $patient->id)
        ->where('status', PatientPackage::STATUS_ACTIVE)
        ->with('servicePackage')
        ->orderByDesc('purchased_at')
        ->get();

    return response()->json(
        $patientPackages->map(function ($patientPackage) {
            return [
                'id' => $patientPackage->id,
                'package_no' => $patientPackage->patient_package_no,
                'package_name' => $patientPackage->servicePackage->package_name,
                'purchased_at' => $patientPackage->purchased_at?->format('Y-m-d'),
                'expired_at' => $patientPackage->expired_at?->format('Y-m-d'),
            ];
        })->values()
    );
}

    /**
     * Display the specified patient package.
     */
    public function show(PatientPackage $patientPackage)
    {
        $patientPackage->load([
            'patient',
            'servicePackage.details.serviceRate',
            'usages.servicePackageDetail.serviceRate',
            'usages.appointment',
        ]);

        return view(
            'patient_packages.show',
            compact('patientPackage')
        );
    }

    /**
     * Show the form for editing the specified patient package.
     */
    public function edit(PatientPackage $patientPackage)
    {
        $patients = Patient::orderBy('name')
            ->get();

        $servicePackages = ServicePackage::where('is_active', true)
            ->with('details.serviceRate')
            ->orderBy('package_name')
            ->get();

        $packageData = $servicePackages->map(function ($package) {
            return [
                'id' => $package->id,
                'price' => $package->price,
                'validity_days' => $package->validity_days,
                'details' => $package->details->map(function ($detail) {
                    return [
                        'service_name' => $detail->serviceRate->service_name,
                        'quantity' => $detail->quantity,
                        'price' => $detail->price,
                    ];
                })->values(),
            ];
        })->values();

        return view(
            'patient_packages.edit',
            compact(
                'patientPackage',
                'patients',
                'servicePackages',
                'packageData'
            )
        );
    }

    /**
     * Update the specified patient package.
     */
    public function update(
        Request $request,
        PatientPackage $patientPackage
    ) {
        $validated = $request->validate([
            'patient_id' => [
                'required',
                'exists:patients,id',
            ],

            'service_package_id' => [
                'required',
                'exists:service_packages,id',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'purchased_at' => [
                'required',
                'date',
            ],

            'started_at' => [
                'nullable',
                'date',
                'after_or_equal:purchased_at',
            ],

            'expired_at' => [
                'nullable',
                'date',
                'after_or_equal:started_at',
            ],

            'status' => [
                'required',
                'integer',
                'in:1,2,3,4',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Jangan mengubah nomor Patient Package
        |--------------------------------------------------------------------------
        */

        $patientPackage->update([
            'patient_id' =>
                $validated['patient_id'],

            'service_package_id' =>
                $validated['service_package_id'],

            'price' =>
                $validated['price'],

            'purchased_at' =>
                $validated['purchased_at'],

            'started_at' =>
                $validated['started_at'] ?? null,

            'expired_at' =>
                $validated['expired_at'] ?? null,

            'status' =>
                $validated['status'],

            'notes' =>
                $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route(
                'patient_packages.show',
                $patientPackage
            )
            ->with(
                'success',
                'Patient Package berhasil diperbarui.'
            );
    }

    /**
     * Soft delete the specified patient package.
     */
    public function destroy(PatientPackage $patientPackage)
    {
        $patientPackage->delete();

        return redirect()
            ->route('patient_packages.index')
            ->with(
                'success',
                'Patient Package berhasil diarsipkan.'
            );
    }

    /**
     * Display archived patient packages.
     */
    public function archived()
    {
        $patientPackages = PatientPackage::onlyTrashed()
            ->with([
                'patient',
                'servicePackage',
            ])
            ->latest('deleted_at')
            ->paginate(10);

        return view(
            'patient_packages.archived',
            compact('patientPackages')
        );
    }

    /**
     * Restore archived patient package.
     */
    public function restore($id)
    {
        $patientPackage = PatientPackage::withTrashed()
            ->findOrFail($id);

        $patientPackage->restore();

        return redirect()
            ->route('patient_packages.archived')
            ->with(
                'success',
                'Patient Package berhasil dipulihkan.'
            );
    }

    public function details(PatientPackage $patientPackage)
    {
        // Pastikan paket masih aktif
        if ($patientPackage->status !== PatientPackage::STATUS_ACTIVE) {
            return response()->json([
                'message' => 'Paket pasien tidak aktif.'
            ], 422);
        }

        // Ambil detail paket beserta service rate
        $patientPackage->load([
            'servicePackage.details.serviceRate',
        ]);

        // Hitung jumlah yang sudah digunakan per detail
        $usedByDetail = PatientPackageUsage::where(
            'patient_package_id',
            $patientPackage->id
        )
            ->selectRaw('service_package_detail_id, SUM(quantity) as used')
            ->groupBy('service_package_detail_id')
            ->pluck('used', 'service_package_detail_id');

        return response()->json(
            $patientPackage->servicePackage->details
                ->map(function ($detail) use ($usedByDetail) {

                    $used = (int) ($usedByDetail[$detail->id] ?? 0);

                    $remaining = max(
                        0,
                        $detail->quantity - $used
                    );

                    return [
                        'id' => $detail->id,

                        'service_rate_id' => $detail->service_rate_id,

                        'service_name' => $detail->serviceRate->service_name,

                        'quantity' => $detail->quantity,

                        'used' => $used,

                        'remaining' => $remaining,

                        'price' => $detail->price,
                    ];
                })
                ->values()
        );
    }

}