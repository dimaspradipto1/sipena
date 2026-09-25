<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Pendaftaran Mahasiswa | SIPENA - Universitas Ibnu Sina</title>
    <meta content="Pendaftaran Akun Mahasiswa Baru Sistem Informasi Kinerja dan Tata Kelola Kemahasiswaan (SIPENA)" name="description">
    <meta content="sipena, kemahasiswaan, register, mahasiswa, uis" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo_uis.png') }}" rel="icon">
    <link href="{{ asset('assets/img/logo_uis.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Nunito:300,400,600,700|Poppins:300,400,500,600,700" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Custom Glassmorphism Style -->
    <style>
        :root {
            --primary-green: #046B26;
            --accent-yellow: #FED802;
            --primary-gradient: linear-gradient(135deg, #046B26 0%, #034f1c 100%);
            --accent-gradient: linear-gradient(135deg, #FED802 0%, #cca902 100%);
            --glass-bg: rgba(255, 255, 255, 0.08);
            --glass-border: rgba(255, 255, 255, 0.15);
            --text-muted: #cbd5e1;
            --slate-dark: #0f172a;
            --slate-medium: #64748b;
            --slate-light: #f8fafc;
            --border-color: #e2e8f0;
        }

        html, body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at 10% 20%, #03210b 0%, #050d07 90%);
        }

        .register-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        /* Abstract glowing blobs */
        .register-wrapper::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(254, 216, 2, 0.08) 0%, transparent 70%);
            top: -20%;
            right: -10%;
            z-index: 0;
            pointer-events: none;
        }

        .register-wrapper::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(4, 107, 38, 0.12) 0%, transparent 70%);
            bottom: -15%;
            left: -10%;
            z-index: 0;
            pointer-events: none;
        }

        /* Dual-Pane Floating Card */
        .main-card {
            width: 1040px;
            max-width: 100%;
            min-height: 620px;
            display: flex;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 35px 70px rgba(0, 0, 0, 0.45);
            border: 1px solid rgba(254, 216, 2, 0.12);
            z-index: 1;
            background: #ffffff;
        }

        /* Left Side */
        .card-left {
            flex: 1.1;
            background: linear-gradient(135deg, rgba(4, 107, 38, 0.95) 0%, rgba(2, 60, 21, 0.98) 100%),
                        radial-gradient(circle at 80% 20%, rgba(254, 216, 2, 0.15) 0%, transparent 50%);
            padding: 2.75rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .card-left::after {
            content: '';
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(254, 216, 2, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 1;
        }

        .brand-header {
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 2;
        }

        .brand-logo {
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
        }

        .brand-name {
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            font-family: 'Nunito', sans-serif;
            color: #ffffff;
        }

        .brand-body-content {
            z-index: 2;
            margin: auto 0;
            max-width: 360px;
        }

        .badge-tag {
            display: inline-flex;
            align-items: center;
            background: rgba(254, 216, 2, 0.18);
            border: 1px solid rgba(254, 216, 2, 0.35);
            color: #FED802;
            padding: 0.35rem 0.85rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1.25rem;
        }

        .brand-title {
            font-size: 2.1rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1rem;
            font-family: 'Nunito', sans-serif;
        }

        .brand-title .text-gradient {
            background: linear-gradient(135deg, #ffffff 40%, #FED802 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand-desc {
            color: rgba(255, 255, 255, 0.82);
            font-size: 0.88rem;
            line-height: 1.6;
            margin-bottom: 1.25rem;
        }

        .benefit-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .benefit-list li {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0.6rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .benefit-list li i {
            color: #FED802;
            font-size: 1rem;
        }

        .brand-footer {
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.55);
            z-index: 2;
        }

        /* Right Side: Register Form */
        .card-right {
            flex: 1.15;
            background: #ffffff;
            padding: 2.5rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .register-header {
            margin-bottom: 1.5rem;
        }

        .register-title {
            font-size: 1.65rem;
            font-weight: 700;
            color: var(--slate-dark);
            margin-bottom: 0.25rem;
            font-family: 'Nunito', sans-serif;
        }

        .register-desc {
            color: var(--slate-medium);
            font-size: 0.85rem;
            margin-bottom: 0;
        }

        /* Role Pill Indicator */
        .role-indicator {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
            padding: 0.35rem 0.85rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
        }

        .form-label {
            font-size: 0.82rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.35rem;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            color: var(--slate-medium);
            font-size: 1rem;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .form-input {
            width: 100%;
            padding: 0.72rem 1rem 0.72rem 2.75rem;
            font-size: 0.88rem;
            color: var(--slate-dark);
            background-color: #f8fafc;
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            background-color: #ffffff;
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px rgba(4, 107, 38, 0.12);
            outline: none;
        }

        .form-input:focus + .input-icon {
            color: var(--primary-green);
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            cursor: pointer;
            padding-left: 0.8rem;
            color: var(--slate-medium);
            font-size: 1rem;
            transition: color 0.2s ease;
        }

        .password-toggle:hover {
            color: var(--slate-dark);
        }

        .btn-register {
            background: var(--primary-gradient);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.85rem;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(4, 107, 38, 0.2);
            text-align: center;
            width: 100%;
            margin-top: 0.75rem;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(4, 107, 38, 0.35);
            background: linear-gradient(135deg, #034f1c 0%, #046B26 100%);
        }

        .alert-custom {
            border-radius: 12px;
            font-size: 0.85rem;
            padding: 0.75rem 1rem;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        /* Responsive Breakpoints */
        @media (max-width: 991.98px) {
            .card-left {
                display: none;
            }
            .main-card {
                max-width: 480px;
                min-height: auto;
                border-radius: 24px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
                display: block;
            }
            .card-right {
                padding: 2.5rem 1.75rem;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="register-wrapper">
        <div class="main-card">
            <!-- Left Side: Brand and Benefits -->
            <div class="card-left">
                <div class="brand-header">
                    <img src="{{ asset('assets/img/logo_uis.png') }}" class="brand-logo" alt="Logo UIS" height="42" width="42">
                    <span class="brand-name">SIPENA UIS</span>
                </div>

                <div class="brand-body-content">
                    <span class="badge-tag">Registrasi Mahasiswa</span>
                    <h1 class="brand-title">
                        Catat & Buktikan<br>
                        <span class="text-gradient">Prestasi Terbaikmu</span>
                    </h1>
                    <p class="brand-desc">
                        Daftarkan akun SIPENA untuk mendokumentasikan kejuaraan, sertifikasi, rekognisi, serta rekognisi akademik lainnya di Universitas Ibnu Sina.
                    </p>

                    <ul class="benefit-list">
                        <li>
                            <i class="bi bi-patch-check-fill"></i>
                            Pencatatan prestasi mandiri & Belmawa resmi
                        </li>
                        <li>
                            <i class="bi bi-file-earmark-arrow-down-fill"></i>
                            Unduh template & kelola dokumen LPJ
                        </li>
                        <li>
                            <i class="bi bi-award-fill"></i>
                            Poin SKPI & rekapitulasi portofolio prestasi
                        </li>
                    </ul>
                </div>

                <div class="brand-footer">
                    &copy; {{ date('Y') }} Universitas Ibnu Sina. Hak Cipta Dilindungi Undang-Undang.
                </div>
            </div>

            <!-- Right Side: Registration Form -->
            <div class="card-right">
                <div class="register-card">
                    <!-- Mobile Header (Show only on small screens) -->
                    <div class="text-center d-lg-none mb-4">
                        <img src="{{ asset('assets/img/logo_uis.png') }}" alt="Logo UIS" height="60" width="60" class="mb-2">
                        <h2 class="fw-bold" style="color: var(--primary-green); font-family: 'Nunito', sans-serif; margin-bottom: 0; font-size: 1.6rem;">SIPENA UIS</h2>
                        <p class="text-secondary small mb-0" style="font-weight: 500;">Pendaftaran Akun Mahasiswa</p>
                    </div>

                    <div class="register-header">
                        <h2 class="register-title">Daftar Akun Baru</h2>
                        <p class="register-desc">Lengkapi formulir di bawah ini untuk membuat akun Mahasiswa.</p>
                    </div>

                    <div class="role-indicator">
                        <i class="bi bi-person-badge-fill text-success"></i>
                        <span>Peran Default: <strong>Mahasiswa Aktif UIS</strong></span>
                    </div>

                    <!-- Alert Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-custom mb-3" role="alert">
                            <div class="d-flex align-items-center mb-1">
                                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                                <span class="fw-bold">Pendaftaran Belum Berhasil</span>
                            </div>
                            <ul class="mb-0 ps-3 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.post') }}" class="needs-validation" novalidate>
                        @csrf

                        <!-- Nama Lengkap -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap Mahasiswa</label>
                            <div class="input-wrapper">
                                <span class="input-icon"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" id="name" 
                                    class="form-input" 
                                    placeholder="Contoh: Frida Ayu Wulandari" 
                                    value="{{ old('name') }}" 
                                    required autofocus>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email Aktif</label>
                            <div class="input-wrapper">
                                <span class="input-icon"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" id="email" 
                                    class="form-input" 
                                    placeholder="nama@student.uis.ac.id" 
                                    value="{{ old('email') }}" 
                                    required autocomplete="email">
                            </div>
                            <div class="form-text text-muted" style="font-size: 0.75rem;">
                                Dianjurkan menggunakan email institusi mahasiswa UIS.
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-wrapper">
                                <span class="input-icon"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" id="password" 
                                    class="form-input password-input" 
                                    placeholder="Minimal 6 karakter" 
                                    required autocomplete="new-password">
                                <span class="password-toggle" id="togglePassword">
                                    <i class="bi bi-eye" id="toggleIcon"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <div class="input-wrapper">
                                <span class="input-icon"><i class="bi bi-shield-check"></i></span>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                    class="form-input password-input" 
                                    placeholder="Ulangi password di atas" 
                                    required autocomplete="new-password">
                                <span class="password-toggle" id="toggleConfirmPassword">
                                    <i class="bi bi-eye" id="toggleConfirmIcon"></i>
                                </span>
                            </div>
                        </div>

                        <button class="btn btn-register" type="submit">
                            <i class="bi bi-person-plus-fill me-2"></i> Buat Akun Mahasiswa
                        </button>

                        <div class="text-center mt-3 pt-2 border-top">
                            <p class="text-muted small mb-0">
                                Sudah memiliki akun? 
                                <a href="{{ route('login') }}" class="fw-bold text-success text-decoration-none">Masuk ke Sistem</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toggle Password Visibility Script -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const toggleIcon = document.querySelector('#toggleIcon');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            toggleIcon.classList.toggle('bi-eye');
            toggleIcon.classList.toggle('bi-eye-slash');
        });

        const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
        const passwordConfirmation = document.querySelector('#password_confirmation');
        const toggleConfirmIcon = document.querySelector('#toggleConfirmIcon');

        toggleConfirmPassword.addEventListener('click', function () {
            const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmation.setAttribute('type', type);
            toggleConfirmIcon.classList.toggle('bi-eye');
            toggleConfirmIcon.classList.toggle('bi-eye-slash');
        });
    </script>
</body>

</html>
