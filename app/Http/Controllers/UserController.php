<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::query();

            return DataTables::of($users)
                ->addIndexColumn()
                ->editColumn('role', function ($user) {
                    $badgeClasses = [
                        'superadmin'       => 'bg-danger',
                        'adminbkak'        => 'bg-warning text-dark',
                        'kabid'            => 'bg-info text-dark',
                        'staff'            => 'bg-primary',
                        'pimpinan'         => 'bg-dark',
                        'prodi'            => 'bg-secondary',
                        'dosenpendamping'  => 'bg-success',
                        'mahasiswa'        => 'bg-info',
                    ];
                    $bgClass = $badgeClasses[$user->role] ?? 'bg-secondary';
                    return '<span class="badge ' . $bgClass . '">' . e(strtoupper($user->role)) . '</span>';
                })
                ->editColumn('is_active', function ($user) {
                    if ($user->is_active) {
                        return '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Aktif</span>';
                    }
                    return '<span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Non-Aktif</span>';
                })
                ->addColumn('action', function ($user) {
                    $editUrl = route('users.edit', $user->id);
                    $deleteUrl = route('users.destroy', $user->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    $btnEdit = '<a href="' . $editUrl . '" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil-square"></i> Edit</a>';
                    
                    if (Auth::id() === $user->id) {
                        $btnDelete = '<button class="btn btn-sm btn-outline-secondary" disabled><i class="bi bi-trash"></i> Hapus</button>';
                    } else {
                        $btnDelete = '
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline delete-form">
                                ' . $csrf . '
                                ' . $method . '
                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-id="' . $user->id . '"><i class="bi bi-trash"></i> Hapus</button>
                            </form>';
                    }

                    return '<div class="btn-group" role="group">' . $btnEdit . $btnDelete . '</div>';
                })
                ->rawColumns(['role', 'is_active', 'action'])
                ->make(true);
        }

        return view('pages.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = [
            'superadmin'      => 'Super Admin',
            'adminbkak'       => 'Admin BKAK',
            'kabid'           => 'Kepala Bidang Kemahasiswaan',
            'staff'           => 'Staff Kemahasiswaan',
            'pimpinan'        => 'Pimpinan Universitas',
            'prodi'           => 'Admin Program Studi',
            'dosenpendamping' => 'Dosen Pendamping',
            'mahasiswa'       => 'Mahasiswa',
        ];

        return view('pages.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
            'role'      => ['required', 'string'],
            'is_active' => ['required', 'boolean'],
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required'      => 'Role wajib dipilih.',
            'is_active.required' => 'Status aktif wajib dipilih.',
        ]);

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = [
            'superadmin'      => 'Super Admin',
            'adminbkak'       => 'Admin BKAK',
            'kabid'           => 'Kepala Bidang Kemahasiswaan',
            'staff'           => 'Staff Kemahasiswaan',
            'pimpinan'        => 'Pimpinan Universitas',
            'prodi'           => 'Admin Program Studi',
            'dosenpendamping' => 'Dosen Pendamping',
            'mahasiswa'       => 'Mahasiswa',
        ];

        return view('pages.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password'  => ['nullable', 'string', 'min:8', 'confirmed'],
            'role'      => ['required', 'string'],
            'is_active' => ['required', 'boolean'],
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required'      => 'Role wajib dipilih.',
            'is_active.required' => 'Status aktif wajib dipilih.',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        if (Auth::id() === $user->id) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Anda tidak dapat menghapus akun Anda sendiri!'], 400);
            }
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'User berhasil dihapus.']);
        }

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
