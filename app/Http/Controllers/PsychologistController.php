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

    public function show(Psychologist $psychologist)
        {
            return view('psychologists.show', compact('psychologist'));
        }
    public function edit(Psychologist $psychologist)
    {
        return view('psychologists.edit', compact('psychologist'));
    }

    public function update(Request $request, Psychologist $psychologist)
    {
        $request->validate([
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

        $psychologist->update($request->all());

        return redirect()
            ->route('psychologists.show', $psychologist)
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Psychologist $psychologist)
    {
        $psychologist->delete();

        return redirect()
            ->route('psychologists.index')
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
        $psychologists = Psychologist::onlyTrashed()

            ->when($request->search, function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->where('psychologist_code', 'like', '%' . $request->search . '%')
                    ->orWhere('name', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');

                });

            })

            ->orderBy('deleted_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('psychologists.archived', compact('psychologists'));
    }
    public function restore($id)
    {
        $psychologist = Psychologist::withTrashed()->findOrFail($id);

        $psychologist->restore();

        return redirect()
            ->route('psychologists.archived')
            ->with('success', 'Pasien berhasil dipulihkan.');
    }
}
