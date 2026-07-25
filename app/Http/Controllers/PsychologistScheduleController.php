<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PsychologistSchedule;

class PsychologistScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create()
    {
         return view('psychologist_schedules.create');
    }    
  public function index(Request $request)
    {
        $search = $request->search;

        $schedules = PsychologistSchedule::with('psychologist')

            ->when($search, function ($query) use ($search) {

                $query->whereHas('psychologist', function ($q) use ($search) {

                    $q->where('name', 'like', "%{$search}%");

                });

            })

            ->orderBy('day_of_week')

            ->orderBy('start_time')

            ->paginate(10);

        return view('psychologist_schedules.index', compact(
            'schedules',
            'search'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
 
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
    public function show(string $id)
    {
         return view('psychologist_schedules.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         return view('psychologist_schedules.edit');
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
