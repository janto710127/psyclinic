<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\TimelineType;

class PatientTimelineController extends Controller
{
    public function create(Patient $patient)
    {
        $timelineTypes = TimelineType::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'patient_timelines.create',
            compact('patient', 'timelineTypes')
        );
    }

    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'timeline_date' => 'required|date',
            'type' => 'required|exists:timeline_types,code',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $patient->timelines()->create([
            'type' => $validated['type'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'occurred_at' => $validated['timeline_date'] . ' 00:00:00',
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('patients.show', $patient)
            ->with('success', 'Timeline berhasil ditambahkan.');
    }
}