<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ServicePackage;
use App\Models\ServicePackageDetail;
use App\Models\ServiceRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ServicePackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ServicePackage::with('details.serviceRate');

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('package_code', 'like', '%' . $search . '%')
                ->orWhere('package_name', 'like', '%' . $search . '%');

            });
        }

        $servicePackages = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('service_packages.index', compact('servicePackages'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $serviceRates = ServiceRate::where('is_active', true)
        ->orderBy('service_name')
        ->get();
        // dd($serviceRates);

        return view('service_packages.create', compact('serviceRates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
            $validated = $request->validate([

            // 'package_code' => [
            //     'required',
            //     'string',
            //     'max:20',
            //     'unique:service_packages,package_code',
            // ], klo pakai penomoran auto ini di remark

            // =========================
            // PACKAGE
            // =========================

            'package_name' => [
                'required',
                'string',
                'max:150',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'validity_days' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],

            'notes' => [
                'nullable',
                'string',
            ],


            // =========================
            // DETAIL
            // =========================

            'details' => [
                'required',
                'array',
                'min:1',
            ],

            'details.*.service_rate_id' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('service_rates', 'id')
                    ->where(function ($query) {
                        $query->where('is_active', true);
                    }),
            ],

            'details.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],

        ]);


        // =========================
        // TRANSACTION
        // =========================

        DB::transaction(function () use ($validated) {

            // =========================
            // GENERATE PACKAGE CODE
            // =========================

            $lastPackage = ServicePackage::withTrashed()
                ->orderByDesc('id')
                ->first();

            $nextNumber = $lastPackage
                ? ((int) substr($lastPackage->package_code, 3)) + 1
                : 1;

            $packageCode = 'PKG' . str_pad(
                $nextNumber,
                4,
                '0',
                STR_PAD_LEFT
            );


            // =========================
            // SIMPAN PACKAGE
            // =========================

            $package = ServicePackage::create([

                'package_code' => $packageCode,

                'package_name' => $validated['package_name'],

                'price' => $validated['price'],

                'validity_days' => $validated['validity_days'] ?? null,

                'is_active' => $validated['is_active'],

                'notes' => $validated['notes'] ?? null,

            ]);


            // =========================
            // SIMPAN DETAIL
            // =========================

            foreach ($validated['details'] as $detail) {

                // Ambil Service Rate asli dari database
                $serviceRate = ServiceRate::findOrFail(
                    $detail['service_rate_id']
                );

                ServicePackageDetail::create([

                    'service_package_id' =>
                        $package->id,

                    'service_rate_id' =>
                        $serviceRate->id,

                    'quantity' =>
                        $detail['quantity'],

                    // SNAPSHOT HARGA
                    'price' =>
                        $serviceRate->price,

                ]);
            }

        });


        // =========================
        // REDIRECT
        // =========================

        return redirect()
            ->route('service_packages.index')
            ->with(
                'success',
                'Service Package berhasil disimpan.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $servicePackage = ServicePackage::with('details.serviceRate')
        //     ->findOrFail($id);

        $servicePackage = ServicePackage::withTrashed()
            ->with('details.serviceRate')
            ->findOrFail($id);

        return view(
            'service_packages.show',
            compact('servicePackage')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $servicePackage = ServicePackage::with('details.serviceRate')
            ->findOrFail($id);

        $serviceRates = ServiceRate::where('is_active', true)
            ->orderBy('service_name')
            ->get();

        return view(
            'service_packages.edit',
            compact(
                'servicePackage',
                'serviceRates'
            )
        );
    }
    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, string $id)
{
    $servicePackage = ServicePackage::findOrFail($id);

    $validated = $request->validate(
        [

            // =========================
            // PACKAGE
            // =========================

            'package_name' => [
                'required',
                'string',
                'max:150',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'validity_days' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            // =========================
            // DETAIL
            // =========================

            'details' => [
                'required',
                'array',
                'min:1',
            ],

            'details.*.service_rate_id' => [
                'required',
                'integer',
                'distinct',

                Rule::exists('service_rates', 'id')
                    ->where(function ($query) {
                        $query->where('is_active', true);
                    }),
            ],

            'details.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],

        ],

        [

            'package_name.required' =>
                'Nama Package wajib diisi.',

            'package_name.string' =>
                'Nama Package harus berupa teks.',

            'package_name.max' =>
                'Nama Package maksimal 150 karakter.',

            'price.required' =>
                'Harga Package wajib diisi.',

            'price.numeric' =>
                'Harga Package harus berupa angka.',

            'price.min' =>
                'Harga Package tidak boleh kurang dari 0.',

            'validity_days.integer' =>
                'Masa berlaku harus berupa angka.',

            'validity_days.min' =>
                'Masa berlaku minimal 1 hari.',

            'details.required' =>
                'Minimal harus ada satu layanan.',

            'details.min' =>
                'Minimal harus ada satu layanan.',

            'details.*.service_rate_id.required' =>
                'Layanan wajib dipilih.',

            'details.*.service_rate_id.integer' =>
                'Layanan tidak valid.',

            'details.*.service_rate_id.distinct' =>
                'Layanan yang sama tidak boleh dipilih dua kali.',

            'details.*.service_rate_id.exists' =>
                'Layanan yang dipilih tidak aktif atau tidak tersedia.',

            'details.*.quantity.required' =>
                'Jumlah layanan wajib diisi.',

            'details.*.quantity.integer' =>
                'Jumlah layanan harus berupa angka.',

            'details.*.quantity.min' =>
                'Jumlah layanan minimal 1.',

        ]
    );


 /*
|--------------------------------------------------------------------------
| CEK APAKAH SERVICE PACKAGE SUDAH DIPAKAI APPOINTMENT
|--------------------------------------------------------------------------
*/

$hasAppointment = DB::table('appointments')
    ->join(
        'service_package_details',
        'appointments.service_package_detail_id',
        '=',
        'service_package_details.id'
    )
    ->where(
        'service_package_details.service_package_id',
        $servicePackage->id
    )
    ->exists();


/*
|--------------------------------------------------------------------------
| JIKA SUDAH DIPAKAI APPOINTMENT
|--------------------------------------------------------------------------
| Hanya boleh mengubah is_active.
| Detail lama TIDAK boleh dihapus.
|--------------------------------------------------------------------------
*/

if ($hasAppointment) {

    $servicePackage->update([
        'is_active' => $validated['is_active'],
    ]);

    return redirect()
        ->route(
            'service_packages.show',
            $servicePackage->id
        )
        ->with(
            'success',
            'Status Service Package berhasil diperbarui.'
        );
}


    /*
    |--------------------------------------------------------------------------
    | JIKA BELUM PERNAH DIPAKAI APPOINTMENT
    |--------------------------------------------------------------------------
    | Boleh update package dan detail seperti biasa.
    */

    DB::transaction(function () use (
        $servicePackage,
        $validated
    ) {

        // =========================
        // UPDATE PACKAGE
        // =========================

        $servicePackage->update([

            'package_name' =>
                $validated['package_name'],

            'price' =>
                $validated['price'],

            'validity_days' =>
                $validated['validity_days'] ?? null,

            'is_active' =>
                $validated['is_active'],

            'notes' =>
                $validated['notes'] ?? null,

        ]);


        // =========================
        // HAPUS DETAIL LAMA
        // =========================

        $servicePackage->details()->delete();


        // =========================
        // BUAT DETAIL BARU
        // =========================

        foreach ($validated['details'] as $detail) {

            // Ambil harga asli dari database
            $serviceRate = ServiceRate::findOrFail(
                $detail['service_rate_id']
            );


            ServicePackageDetail::create([

                'service_package_id' =>
                    $servicePackage->id,

                'service_rate_id' =>
                    $serviceRate->id,

                'quantity' =>
                    $detail['quantity'],

                // Snapshot harga terbaru
                'price' =>
                    $serviceRate->price,

            ]);

        }

    });


    return redirect()
        ->route(
            'service_packages.show',
            $servicePackage->id
        )
        ->with(
            'success',
            'Service Package berhasil diperbarui.'
        );
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $servicePackage = ServicePackage::findOrFail($id);

        $servicePackage->delete();

        return redirect()
            ->route('service_packages.index')
            ->with(
                'success',
                'Service Package berhasil diarsipkan.'
            );
    }

    /**
     * RollBack the specified resource from storage.
     */
    public function restore(string $id)
    {
        $servicePackage = ServicePackage::withTrashed()
            ->findOrFail($id);

        $servicePackage->restore();

        return redirect()
            ->route('service_packages.archived')
            ->with(
                'success',
                'Service Package berhasil direstore.'
            );
    }

    public function archived()
    {
        $servicePackages = ServicePackage::onlyTrashed()
            ->with('details.serviceRate')
            ->latest('deleted_at')
            ->paginate(10);

        return view(
            'service_packages.archived',
            compact('servicePackages')
        );
    }
}
