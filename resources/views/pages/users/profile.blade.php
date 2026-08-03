@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Profil Saya</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
            <li class="breadcrumb-item active">Profil</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section profile">
    <div class="row">

        @if(session('success'))
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <div class="col-xl-4">
            <div class="card shadow-sm">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=cbd5e1&color=334155" alt="Profile" class="rounded-circle">
                    <span class="badge bg-primary text-uppercase px-3 py-2 my-2">{{ $user->role }}</span>
                    <p class="text-muted small m-0"><i class="bi bi-envelope me-1"></i>{{ $user->email }}</p>
                    <div class="mt-2">
                        @if($user->is_active)
                            <span class="badge bg-success-subtle text-success border border-success"><i class="bi bi-check-circle me-1"></i> Akun Aktif</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger border border-danger"><i class="bi bi-x-circle me-1"></i> Non-Aktif</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card shadow-sm">
                <div class="card-body pt-3">

                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit" role="tab"><i class="bi bi-person-gear me-1"></i> Edit Profil</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password" role="tab"><i class="bi bi-key me-1"></i> Ubah Password</button>
                        </li>
                    </ul>

                    <div class="tab-content pt-3">

                        <!-- Edit Profile Tab -->
                        <div class="tab-pane fade show active profile-edit" id="profile-edit" role="tabpanel">
                            <form action="{{ route('profile.update') }}" method="POST" class="row g-3">
                                @csrf
                                @method('PUT')

                                <div class="col-12">
                                    <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="email" class="form-label">Alamat Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 text-end mt-4">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="bi bi-save me-1"></i> Simpan Perubahan Profil
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Change Password Tab -->
                        <div class="tab-pane fade profile-change-password" id="profile-change-password" role="tabpanel">
                            <form action="{{ route('password.update') }}" method="POST" class="row g-3">
                                @csrf
                                @method('PUT')

                                <div class="col-12">
                                    <label for="current_password" class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" placeholder="Masukkan password saat ini" required>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 8 karakter" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru" required>
                                </div>

                                <div class="col-12 text-end mt-4">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="bi bi-shield-lock me-1"></i> Perbarui Password
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div><!-- End Bordered Tabs -->

                </div>
            </div>
        </div>

    </div>
</section>
@endsection
