<?php

namespace App\Http\Controllers;

use App\Models\Psychologist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PsychologistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 
    public function create()
    {
         return view('psychologists.create');
    }
    public function index(Request $request)
    {

        $search = $request->search;

        $psychologists = Psychologist::query()

            ->when($request->search, function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->where('psychologist_code', 'like', '%' . $request->search . '%')
                    ->orWhere('name', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');

                });

            })

            ->orderBy('name')

            ->paginate(20)

            ->withQueryString();

        return view(
            'psychologists.index',
            compact('psychologists','search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|max:255',
            'gender'           => 'required',
            'phone'            => 'nullable|max:30',
            'email'            => 'nullable|email',
            'sip_number'       => 'nullable|max:100',
            'str_number'       => 'nullable|max:100',
            'specialization'   => 'nullable|max:255',
            'notes'            => 'nullable',
            'is_active'        => 'required|boolean',
        ]);

        $last = Psychologist::withTrashed()->latest('id')->first();

        if ($last) {
            $number = ((int) substr($last->psychologist_code, 3)) + 1;
        } else {
            $number = 1;
        }

        $validated['psychologist_code'] = 'PS' . str_pad($number, 4, '0', STR_PAD_LEFT);

        Psychologist::create($validated);

        return redirect()
            ->route('psychologists.index')
            ->with('success', 'Psikolog berhasil ditambahkan.');
    }

    public function show(Patient $patient)
        {
            $patient->load('timelines');

            return view('patients.show', compact('patient'));
        }
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable',
            'email' => 'nullable|email',
            'address' => 'nullable',
            'occupation' => 'nullable',
            'education' => 'nullable',
            'marital_status' => 'nullable',
            'emergency_contact_name' => 'nullable',
            'emergency_contact_phone' => 'nullable',
            'notes' => 'nullable',
        ]);

        $patient->update($request->all());

        return redirect()
            ->route('patients.show', $patient)
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()
            ->route('patients.index')
            ->with('success', 'Pasien berhasil diarsipkan.');
    }

    // public function archived()
    // {
    //     $patients = Patient::onlyTrashed()
    //         ->orderBy('deleted_at', 'desc')
    //         ->paginate(20);

    //     return view('patients.archived', compact('patients'));
    // }

    public function archived(Request $request)
    {
        $patients = Patient::onlyTrashed()

            ->when($request->search, function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->where('patient_number', 'like', '%' . $request->search . '%')
                    ->orWhere('name', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');

                });

            })

            ->orderBy('deleted_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('patients.archived', compact('patients'));
    }
    public function restore($id)
    {
        $patient = Patient::withTrashed()->findOrFail($id);

        $patient->restore();

        return redirect()
            ->route('patients.archived')
            ->with('success', 'Pasien berhasil dipulihkan.');
    }
}
