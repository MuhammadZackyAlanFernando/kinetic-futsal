<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Kinetic Futsal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --dark-green: #1a3c2e;
            --medium-green: #2d6a4f;
            --light-green: #52b788;
            --bg: #f4f6f4;
        }
        * { font-family: 'Poppins', sans-serif; box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: flex; background: var(--bg); }

        /* ── LEFT PANEL ── */
        .auth-left {
            width: 45%;
            background: linear-gradient(145deg, #0d2318 0%, var(--dark-green) 40%, var(--medium-green) 100%);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 3rem 2.5rem;
            position: relative; overflow: hidden;
        }
        /* Animated hexagon pattern */
        .auth-left::before {
            content: '';
            position: absolute; inset: 0;
            background-image:
                radial-gradient(circle at 20% 20%, rgba(82,183,136,.18) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(82,183,136,.12) 0%, transparent 50%);
            animation: pulseGlow 6s ease-in-out infinite alternate;
        }
        @keyframes pulseGlow {
            from { opacity: .6; transform: scale(1); }
            to   { opacity: 1;  transform: scale(1.05); }
        }
        .floating-shapes span {
            position: absolute;
            display: block;
            border-radius: 50%;
            background: rgba(82,183,136,.08);
            animation: floatUp 8s infinite linear;
        }
        .floating-shapes span:nth-child(1)  { width:60px;  height:60px;  left:10%; animation-duration:7s; animation-delay:0s; }
        .floating-shapes span:nth-child(2)  { width:100px; height:100px; left:25%; animation-duration:10s; animation-delay:2s; }
        .floating-shapes span:nth-child(3)  { width:40px;  height:40px;  left:60%; animation-duration:6s; animation-delay:1s; }
        .floating-shapes span:nth-child(4)  { width:80px;  height:80px;  left:75%; animation-duration:9s; animation-delay:3s; }
        .floating-shapes span:nth-child(5)  { width:50px;  height:50px;  left:85%; animation-duration:8s; animation-delay:0.5s; }
        @keyframes floatUp {
            0%   { transform: translateY(100vh) rotate(0deg);   opacity:0; }
            10%  { opacity:.4; }
            90%  { opacity:.2; }
            100% { transform: translateY(-120px) rotate(360deg); opacity:0; }
        }
        .auth-brand { position: relative; z-index: 2; text-align: center; color: #fff; }
        .brand-icon {
            width: 90px; height: 90px;
            background: rgba(255,255,255,.12);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.4rem; color: var(--light-green);
            margin: 0 auto 1.5rem;
            border: 1px solid rgba(255,255,255,.2);
            box-shadow: 0 8px 32px rgba(0,0,0,.2);
            animation: floatBrand 4s ease-in-out infinite;
        }
        @keyframes floatBrand {
            0%,100% { transform: translateY(0); }
            50%      { transform: translateY(-8px); }
        }
        .auth-brand h1 { font-size: 2rem; font-weight: 800; letter-spacing: -0.5px; margin-bottom: .5rem; }
        .auth-brand p  { font-size: .95rem; opacity: .75; max-width: 280px; margin: 0 auto; line-height: 1.6; }
        .auth-features { position: relative; z-index: 2; margin-top: 2.5rem; width: 100%; max-width: 320px; }
        .feature-item {
            display: flex; align-items: center; gap: .85rem;
            color: rgba(255,255,255,.85); font-size: .88rem; margin-bottom: 1rem;
        }
        .feature-icon {
            width: 36px; height: 36px;
            background: rgba(82,183,136,.2);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: var(--light-green); font-size: .9rem; flex-shrink: 0;
        }

        /* ── RIGHT PANEL ── */
        .auth-right {
            flex: 1;
            display: flex; align-items: center; justify-content: center;
            padding: 2rem;
        }
        .auth-form-card {
            width: 100%; max-width: 420px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,.08);
            padding: 2.5rem 2.5rem;
        }
        .auth-form-card h2 { font-size: 1.6rem; font-weight: 700; color: var(--dark-green); margin-bottom: .35rem; }
        .auth-form-card p.subtitle { color: #6c757d; font-size: .9rem; margin-bottom: 1.75rem; }

        /* Floating label style */
        .form-floating > .form-control {
            border: 2px solid #e8eae8;
            border-radius: 12px;
            padding: 1rem 1rem 1rem 3rem;
            height: 58px;
            font-size: .95rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-floating > .form-control:focus {
            border-color: var(--light-green);
            box-shadow: 0 0 0 4px rgba(82,183,136,.15);
            outline: none;
        }
        .form-floating > label { padding-left: 3rem; color: #9ca3af; font-size: .9rem; }
        .input-wrapper { position: relative; margin-bottom: 1.1rem; }
        .input-wrapper .form-control {
            border: 2px solid #e8eae8;
            border-radius: 12px;
            padding-left: 2.75rem;
            padding-right: 2.75rem;
            height: 52px;
            font-size: .95rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .input-wrapper .form-control:focus {
            border-color: var(--light-green);
            box-shadow: 0 0 0 4px rgba(82,183,136,.15);
            outline: none;
        }
        .input-icon {
            position: absolute;
            left: 14px; top: 50%; transform: translateY(-50%);
            color: var(--light-green); font-size: .95rem; z-index: 5;
            pointer-events: none;
        }
        .password-toggle {
            position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            cursor: pointer; color: #9ca3af; z-index: 5; background: none; border: none;
            transition: color .2s;
        }
        .password-toggle:hover { color: var(--medium-green); }

        /* Checkbox */
        .form-check-input:checked { background-color: var(--medium-green); border-color: var(--medium-green); }
        .form-check-label { font-size: .88rem; color: #6c757d; }

        /* Submit button */
        .btn-login {
            background: linear-gradient(135deg, var(--medium-green), var(--dark-green));
            border: none; color: #fff;
            font-weight: 600; font-size: 1rem;
            padding: .85rem;
            border-radius: 12px; width: 100%;
            letter-spacing: .3px;
            transition: opacity .2s, transform .15s, box-shadow .2s;
            box-shadow: 0 4px 15px rgba(45,106,79,.35);
        }
        .btn-login:hover {
            opacity: .92; transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(45,106,79,.45);
            color: #fff;
        }
        .btn-login:active { transform: translateY(0); }

        .divider { text-align: center; color: #d1d5db; font-size: .85rem; margin: 1.25rem 0; position: relative; }
        .divider::before, .divider::after {
            content: ''; position: absolute; top: 50%; width: 42%; height: 1px; background: #e5e7eb;
        }
        .divider::before { left: 0; }
        .divider::after  { right: 0; }

        .register-link { text-align: center; font-size: .9rem; color: #6c757d; }
        .register-link a { color: var(--medium-green); font-weight: 600; text-decoration: none; }
        .register-link a:hover { color: var(--dark-green); text-decoration: underline; }

        /* Alert */
        .alert { border-radius: 12px; font-size: .88rem; border: none; }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-danger  { background: #fee2e2; color: #991b1b; }

        /* Responsive */
        @media (max-width: 768px) {
            .auth-left { display: none; }
            .auth-right { padding: 1.5rem; }
            .auth-form-card { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>
    <!-- LEFT PANEL -->
    <div class="auth-left">
        <div class="floating-shapes">
            <span></span><span></span><span></span><span></span><span></span>
        </div>
        <div class="auth-brand">
            <div class="brand-icon"><i class="fas fa-futbol"></i></div>
            <h1>Kinetic Futsal</h1>
            <p>Platform booking lapangan futsal terpercaya untuk pengalaman bermain terbaik Anda.</p>
        </div>
        <div class="auth-features">
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-bolt"></i></div>
                <span>Booking cepat dalam hitungan menit</span>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                <span>Sistem keamanan terpercaya</span>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-clock"></i></div>
                <span>Tersedia 24/7 untuk reservasi online</span>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="auth-right">
        <div class="auth-form-card">
            <h2>Selamat Datang 👋</h2>
            <p class="subtitle">Masuk ke akun Anda untuk melanjutkan</p>

            {{-- Flash Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Error Message --}}
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Email -->
                <div class="input-wrapper">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" id="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Email address"
                           value="{{ old('email') }}" required autocomplete="email">
                </div>

                <!-- Password -->
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" id="password"
                           class="form-control"
                           placeholder="Password" required>
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>

                <!-- Remember Me -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk Sekarang
                </button>
            </form>

            <div class="divider">atau</div>

            <p class="register-link">
                Belum punya akun?
                <a href="{{ route('register') }}">Daftar sekarang</a>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const eye = document.getElementById('eyeIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                eye.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                pwd.type = 'password';
                eye.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>