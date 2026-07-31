<?php

namespace App\Http\Controllers;

use App\Models\ServiceRate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TimelineType;
use App\Models\Psychologist;

class ServiceRateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
    {
        $search = $request->search;

        $serviceRates = ServiceRate::with([
                'timelineType',
                'psychologist'
            ])

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('service_code', 'like', "%{$search}%")
                    ->orWhere('service_name', 'like', "%{$search}%");

                });

            })

            ->orderBy('service_code')

            ->paginate(10);

        return view(
            'service_rates.index',
            compact(
                'serviceRates',
                'search'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $timelineTypes = TimelineType::orderBy('name')->get();

        $psychologists = Psychologist::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'service_rates.create',
            compact(
                'timelineTypes',
                'psychologists'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'timeline_type_id' => 'required',
            'service_name' => 'required|max:150',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'psychologist_id' => 'nullable',
            'is_active' => 'nullable',
            'notes' => 'nullable',
        ]);

        $last = ServiceRate::withTrashed()->latest('id')->first();

        if ($last) {
            $number = ((int) substr($last->service_code, 3)) + 1;
        } else {
            $number = 1;
        }

        $temp = 'SVR' . str_pad($number, 4, '0', STR_PAD_LEFT);

        ServiceRate::create([
            'service_code' => $temp,
            'timeline_type_id' => $request->timeline_type_id,
            'psychologist_id' => $request->psychologist_id,
            'service_name' => $request->service_name,
            'duration' => $request->duration,
            'price' => $request->price,
            'is_active' => $request->is_active,
            'notes' => $request->notes,
        ]);

        return redirect()
            ->route('service_rates.index')
            ->with('success', 'Tarif layanan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceRate $serviceRate)
    {
        return view(
            'service_rates.show',
            compact('serviceRate')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceRate $serviceRate)
    {
        //
       $timelineTypes = TimelineType::orderBy('name')->get();

        $psychologists = Psychologist::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'service_rates.edit',
            compact('serviceRate',
                'timelineTypes',
                'psychologists'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceRate $serviceRate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceRate $serviceRate)
    {
        //
    }
}
