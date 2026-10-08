<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index(Request $request)
    {
        $query = Organization::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('organization_code', 'like', '%' . $search . '%')
                  ->orWhere('organization_name', 'like', '%' . $search . '%');
            });
        }

        $organizations = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'organizations.index',
            compact('organizations')
        );
    }

    public function create()
    {
        return view('organizations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'organization_name' => [
                    'required',
                    'string',
                    'max:150',
                ],
                'address' => [
                    'nullable',
                    'string',
                ],
                'phone' => [
                    'nullable',
                    'string',
                    'max:30',
                ],
                'email' => [
                    'nullable',
                    'email',
                    'max:150',
                ],
                'is_active' => [
                    'required',
                    'boolean',
                ],
                'notes' => [
                    'nullable',
                    'string',
                ],
            ],
            [
                'organization_name.required' =>
                    'Nama Organization wajib diisi.',

                'organization_name.max' =>
                    'Nama Organization maksimal 150 karakter.',

                'phone.max' =>
                    'Nomor telepon maksimal 30 karakter.',

                'email.email' =>
                    'Format email tidak valid.',

                'email.max' =>
                    'Email maksimal 150 karakter.',
            ]
        );

        /*
         * Kode Organization dibuat otomatis.
         * Contoh:
         * ORG0001
         * ORG0002
         */
        $lastOrganization = Organization::withTrashed()
            ->orderByDesc('id')
            ->first();

        $nextNumber = $lastOrganization
            ? ((int) substr(
                $lastOrganization->organization_code,
                3
            )) + 1
            : 1;

        $organizationCode = 'ORG' . str_pad(
            $nextNumber,
            4,
            '0',
            STR_PAD_LEFT
        );

        Organization::create([
            'organization_code' => $organizationCode,
            'organization_name' => $validated['organization_name'],
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'is_active' => $validated['is_active'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('organizations.index')
            ->with(
                'success',
                'Organization berhasil disimpan.'
            );
    }

    public function show(string $id)
    {
        $organization = Organization::withTrashed()
            ->with('branches')
            ->findOrFail($id);

        return view(
            'organizations.show',
            compact('organization')
        );
    }

    public function edit(string $id)
    {
        $organization = Organization::findOrFail($id);

        return view(
            'organizations.edit',
            compact('organization')
        );
    }

    public function update(Request $request, string $id)
    {
        $organization = Organization::findOrFail($id);

        $validated = $request->validate(
            [
                'organization_name' => [
                    'required',
                    'string',
                    'max:150',
                ],
                'address' => [
                    'nullable',
                    'string',
                ],
                'phone' => [
                    'nullable',
                    'string',
                    'max:30',
                ],
                'email' => [
                    'nullable',
                    'email',
                    'max:150',
                ],
                'is_active' => [
                    'required',
                    'boolean',
                ],
                'notes' => [
                    'nullable',
                    'string',
                ],
            ],
            [
                'organization_name.required' =>
                    'Nama Organization wajib diisi.',

                'organization_name.max' =>
                    'Nama Organization maksimal 150 karakter.',

                'phone.max' =>
                    'Nomor telepon maksimal 30 karakter.',

                'email.email' =>
                    'Format email tidak valid.',

                'email.max' =>
                    'Email maksimal 150 karakter.',
            ]
        );

        $organization->update([
            'organization_name' => $validated['organization_name'],
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'is_active' => $validated['is_active'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route(
                'organizations.show',
                $organization->id
            )
            ->with(
                'success',
                'Organization berhasil diperbarui.'
            );
    }

    public function destroy(string $id)
    {
        $organization = Organization::findOrFail($id);

        $organization->delete();

        return redirect()
            ->route('organizations.index')
            ->with(
                'success',
                'Organization berhasil diarsipkan.'
            );
    }

    public function archived()
    {
        $organizations = Organization::onlyTrashed()
            ->with('branches')
            ->latest('deleted_at')
            ->paginate(10);

        return view(
            'organizations.archived',
            compact('organizations')
        );
    }

    public function restore(string $id)
    {
        $organization = Organization::withTrashed()
            ->findOrFail($id);

        $organization->restore();

        return redirect()
            ->route('organizations.archived')
            ->with(
                'success',
                'Organization berhasil direstore.'
            );
    }
}