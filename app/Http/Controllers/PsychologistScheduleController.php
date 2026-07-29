<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PsychologistSchedule;
use App\Models\Psychologist;

class PsychologistScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create()
    {
        $psychologists = Psychologist::where('is_active', 1)
            ->orderBy('name')
            ->get();

        return view(
            'psychologist_schedules.create',
            compact('psychologists')
        );
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
            $request->validate([
                'psychologist_id' => 'required',
                'day_of_week' => 'required',
                'start_time' => 'nullable',
                'end_time' => 'nullable',
                'slot_duration' => 'nullable',
                'is_active' => 'nullable',
                'notes' => 'nullable',
            ]);

            PsychologistSchedule::create([
                'psychologist_id' => $request->psychologist_id,
                'day_of_week' => $request->day_of_week,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'slot_duration' => $request->slot_duration,
                'is_active' => $request->is_active,
                'notes' => $request->notes,
            ]);

            return redirect()
                ->route('psychologist_schedules.index')
                ->with('success', 'Jadwal Praktek berhasil ditambahkan.');
        }

    /**
     * Display the specified resource.
     */
 public function show(PsychologistSchedule $psychologist_schedule)
{
    return view('psychologist_schedules.show', [
        'schedule' => $psychologist_schedule,
    ]);
}

public function edit(PsychologistSchedule $psychologist_schedule)
{
    $psychologists = Psychologist::where('is_active', 1)
        ->orderBy('name')
        ->get();

    return view('psychologist_schedules.edit', [
        'schedule' => $psychologist_schedule,
        'psychologists' => $psychologists,
    ]);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PsychologistSchedule $psychologist_schedule)

    {

            $request->validate([
                'day_of_week' => 'required',
                'start_time' => 'nullable',
                'end_time' => 'nullable',
                'slot_duration' => 'nullable',
                'is_active' => 'nullable',
                'notes' => 'nullable',
            ]);

            $psychologist_schedule->update($request->all());

                 return redirect()
                ->route('psychologist_schedules.show',$psychologist_schedule)
                ->with('success', 'Jadwal Praktek berhasil dirubah.');
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PsychologistSchedule $psychologist_schedule)
    {
        $psychologist_schedule->delete();

        return redirect()
            ->route('psychologist_schedules.index')
            ->with('success', 'Jadwal Praktek berhasil diarsipkan.');
    }

    public function archived(Request $request)
    {
        $search = $request->search;

        $schedules = PsychologistSchedule::onlyTrashed()
            ->with('psychologist')

            ->when($search, function ($query) use ($search) {

                $query->whereHas('psychologist', function ($q) use ($search) {

                    $q->where('name', 'like', "%{$search}%");

                });

            })

            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->paginate(10);

        return view(
            'psychologist_schedules.archived',
            compact('schedules', 'search')
        );
    }
   public function restore($id)
    {
        $schedule = PsychologistSchedule::withTrashed()->findOrFail($id);

        $schedule->restore();

        return redirect()
            ->route('psychologist_schedules.archived')
            ->with('success', 'Jadwal Praktek berhasil dipulihkan.');
    }
}
