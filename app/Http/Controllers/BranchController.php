<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        $query = Branch::with('organization');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('branch_code', 'like', '%' . $search . '%')
                  ->orWhere('branch_name', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('organization_id')) {
            $query->where(
                'organization_id',
                $request->organization_id
            );
        }

        $branches = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $organizations = Organization::where('is_active', true)
            ->orderBy('organization_name')
            ->get();

        return view(
            'branches.index',
            compact(
                'branches',
                'organizations'
            )
        );
    }

    public function create(Request $request)
    {
        $organizations = Organization::where('is_active', true)
            ->orderBy('organization_name')
            ->get();

        $selectedOrganization = null;

        if ($request->filled('organization_id')) {
            $selectedOrganization = Organization::findOrFail(
                $request->organization_id
            );
        }

        return view(
            'branches.create',
            compact(
                'organizations',
                'selectedOrganization'
            )
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'organization_id' => [
                    'required',
                    'integer',
                    Rule::exists('organizations', 'id')
                        ->where(function ($query) {
                            $query->where('is_active', true);
                        }),
                ],

                'branch_name' => [
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
                'organization_id.required' =>
                    'Organization wajib dipilih.',

                'organization_id.exists' =>
                    'Organization tidak valid atau tidak aktif.',

                'branch_name.required' =>
                    'Nama Branch wajib diisi.',

                'branch_name.max' =>
                    'Nama Branch maksimal 150 karakter.',

                'phone.max' =>
                    'Nomor telepon maksimal 30 karakter.',

                'email.email' =>
                    'Format email tidak valid.',

                'email.max' =>
                    'Email maksimal 150 karakter.',
            ]
        );

        /*
         * Kode Branch dibuat otomatis.
         *
         * Contoh:
         * BR0001
         * BR0002
         *
         * Nomor dihitung berdasarkan Organization.
         */

        $lastBranch = Branch::withTrashed()
            ->where(
                'organization_id',
                $validated['organization_id']
            )
            ->orderByDesc('id')
            ->first();

        $nextNumber = $lastBranch
            ? ((int) substr($lastBranch->branch_code, 2)) + 1
            : 1;

        $branchCode = 'BR' . str_pad(
            $nextNumber,
            4,
            '0',
            STR_PAD_LEFT
        );

        Branch::create([
            'organization_id' => $validated['organization_id'],
            'branch_code' => $branchCode,
            'branch_name' => $validated['branch_name'],
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'is_active' => $validated['is_active'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('branches.index')
            ->with(
                'success',
                'Branch berhasil disimpan.'
            );
    }

    public function show(string $id)
    {
        $branch = Branch::withTrashed()
            ->with('organization')
            ->findOrFail($id);

        return view(
            'branches.show',
            compact('branch')
        );
    }

    public function edit(string $id)
    {
        $branch = Branch::findOrFail($id);

        $organizations = Organization::where('is_active', true)
            ->orderBy('organization_name')
            ->get();

        return view(
            'branches.edit',
            compact(
                'branch',
                'organizations'
            )
        );
    }

    public function update(Request $request, string $id)
    {
        $branch = Branch::findOrFail($id);

        $validated = $request->validate(
            [
                'organization_id' => [
                    'required',
                    'integer',
                    Rule::exists('organizations', 'id')
                        ->where(function ($query) {
                            $query->where('is_active', true);
                        }),
                ],

                'branch_name' => [
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
            ]
        );

        $branch->update([
            'organization_id' => $validated['organization_id'],
            'branch_name' => $validated['branch_name'],
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'is_active' => $validated['is_active'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('branches.show', $branch->id)
            ->with(
                'success',
                'Branch berhasil diperbarui.'
            );
    }

    public function destroy(string $id)
    {
        $branch = Branch::findOrFail($id);

        $branch->delete();

        return redirect()
            ->route('branches.index')
            ->with(
                'success',
                'Branch berhasil diarsipkan.'
            );
    }

    public function archived()
    {
        $branches = Branch::onlyTrashed()
            ->with('organization')
            ->latest('deleted_at')
            ->paginate(10);

        return view(
            'branches.archived',
            compact('branches')
        );
    }

    public function restore(string $id)
    {
        $branch = Branch::withTrashed()
            ->findOrFail($id);

        $branch->restore();

        return redirect()
            ->route('branches.archived')
            ->with(
                'success',
                'Branch berhasil direstore.'
            );
    }
}