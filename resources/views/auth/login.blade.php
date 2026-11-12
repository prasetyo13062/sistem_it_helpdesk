<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Masuk - IT Helpdesk Portal</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            background: radial-gradient(circle at top right, #1e293b, #0f172a 60%, #020617);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #f8fafc;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient background glow effects */
        .ambient-glow-1 {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.15) 0%, rgba(0, 0, 0, 0) 70%);
            top: -100px;
            right: -100px;
            border-radius: 50%;
            pointer-events: none;
        }

        .ambient-glow-2 {
            position: absolute;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.12) 0%, rgba(0, 0, 0, 0) 70%);
            bottom: -80px;
            left: -80px;
            border-radius: 50%;
            pointer-events: none;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.45);
            padding: 40px 36px;
            position: relative;
            z-index: 10;
        }

        .brand-icon-box {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.45);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: white;
            margin-bottom: 20px;
        }

        .form-control {
            background-color: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #f8fafc;
            border-radius: 12px;
            padding: 12px 14px 12px 42px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            background-color: rgba(15, 23, 42, 0.85);
            border-color: #3b82f6;
            color: #ffffff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
        }

        .form-control::placeholder {
            color: #64748b;
        }

        .input-icon-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 17px;
            z-index: 5;
            transition: color 0.2s ease;
        }

        .input-icon-wrapper:focus-within .input-icon {
            color: #60a5fa;
        }

        .btn-submit {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border: none;
            color: white;
            border-radius: 12px;
            padding: 13px;
            font-weight: 600;
            font-size: 15px;
            width: 100%;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.35);
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.45);
            color: white;
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            border-radius: 12px;
            font-size: 13px;
            padding: 12px 14px;
        }
    </style>
</head>

<body>

    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>

    <div class="login-card">
        {{-- Branding --}}
        <div class="text-center">
            <div class="brand-icon-box">
                <i class="bi bi-headset"></i>
            </div>
            <h3 class="fw-bold text-white mb-1">
                IT Helpdesk
            </h3>
            <p class="text-muted small mb-4">
                Masuk ke akun Anda untuk mengelola atau melaporkan kendala IT
            </p>
        </div>

        {{-- Errors --}}
        @if (isset($errors) && $errors->any())
            <div class="alert alert-danger d-flex align-items-center mb-4">
                <i class="bi bi-exclamation-octagon-fill me-2 fs-5"></i>
                <div>
                    {{ $errors->first() }}
                </div>
            </div>
        @endif

        {{-- Login Form --}}
        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            {{-- Email --}}
            <div class="mb-3">
                <label class="form-label small fw-semibold text-slate-300">
                    Alamat Email
                </label>
                <div class="input-icon-wrapper">
                    <i class="bi bi-envelope input-icon"></i>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email') }}"
                           placeholder="nama@perusahaan.com"
                           required
                           autofocus>
                </div>
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label class="form-label small fw-semibold text-slate-300">
                    Kata Sandi
                </label>
                <div class="input-icon-wrapper">
                    <i class="bi bi-lock input-icon"></i>
                    <input type="password"
                           id="passwordInput"
                           name="password"
                           class="form-control"
                           placeholder="••••••••"
                           required>
                    <button type="button"
                            id="togglePassword"
                            class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted pe-3 text-decoration-none"
                            style="z-index: 10;">
                        <i class="bi bi-eye" id="togglePasswordIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-submit mb-3">
                <span>Masuk Sekarang</span>
                <i class="bi bi-arrow-right ms-1"></i>
            </button>
        </form>

        <div class="text-center mt-3">
            <small class="text-muted">
                IT Helpdesk System &copy; {{ date('Y') }} &bull; Layanan Teknis Terpadu
            </small>
        </div>
    </div>

    <!-- Script for password visibility toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('passwordInput');
            const toggleIcon = document.getElementById('togglePasswordIcon');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    toggleIcon.classList.toggle('bi-eye', !isPassword);
                    toggleIcon.classList.toggle('bi-eye-slash', isPassword);
                });
            }
        });
    </script>

</body>

</html>