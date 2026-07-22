<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    // public function index()
    // {
    //     $patients = Patient::latest()->paginate(20);
    //     return view('patients.index', compact('patients'));
    // }

    public function create()
    {
         return view('patients.create');
    }

    public function index(Request $request)
        {
            $keyword = $request->keyword;

            $patients = Patient::query()

                ->when($keyword, function ($query) use ($keyword) {

                    $query->where('patient_number', 'like', "%{$keyword}%")
                        ->orWhere('name', 'like', "%{$keyword}%")
                        ->orWhere('phone', 'like', "%{$keyword}%");

                })

                ->latest()

                ->paginate(20)

                ->withQueryString();

            return view('patients.index', compact('patients', 'keyword'));
            
        }

    public function store(Request $request)

        {
            $request->validate([
                'name' => 'required',
                'gender' => 'required',
                'phone' => 'nullable',
            ]);

            $lastPatient = Patient::latest('id')->first();

            $number = $lastPatient
                ? $lastPatient->id + 1
                : 1;

            $patientNumber = 'PSY-' . str_pad($number, 6, '0', STR_PAD_LEFT);

            Patient::create([
                'patient_number' => $patientNumber,
                'name' => $request->name,
                'gender' => $request->gender,
                'phone' => $request->phone,
            ]);

            return redirect()
                ->route('patients.index')
                ->with('success', 'Pasien berhasil ditambahkan.');
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

}