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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
