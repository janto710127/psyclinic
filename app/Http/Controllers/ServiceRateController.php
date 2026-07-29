<?php

namespace App\Http\Controllers;

use App\Models\ServiceRate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceRate $serviceRate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceRate $serviceRate)
    {
        //
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
