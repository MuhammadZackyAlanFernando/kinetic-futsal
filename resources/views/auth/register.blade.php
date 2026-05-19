<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — Kinetic Futsal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --dark-green: #1a3c2e;
            --medium-green: #2d6a4f;
            --light-green: #52b788;
        }
        * { font-family: 'Poppins', sans-serif; box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: flex; background: #f4f6f4; }

        .auth-left {
            width: 42%;
            background: linear-gradient(145deg, #0d2318 0%, var(--dark-green) 40%, var(--medium-green) 100%);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 3rem 2rem; position: relative; overflow: hidden;
        }
        .auth-left::before {
            content: ''; position: absolute; inset: 0;
            background-image:
                radial-gradient(circle at 20% 20%, rgba(82,183,136,.18) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(82,183,136,.12) 0%, transparent 50%);
            animation: pulseGlow 6s ease-in-out infinite alternate;
        }
        @keyframes pulseGlow {
            from { opacity:.6; transform:scale(1); }
            to   { opacity:1;  transform:scale(1.05); }
        }
        .floating-shapes span {
            position: absolute; display: block; border-radius: 50%;
            background: rgba(82,183,136,.08);
            animation: floatUp 8s infinite linear;
        }
        .floating-shapes span:nth-child(1) { width:60px;  height:60px;  left:10%; animation-duration:7s;  animation-delay:0s;   }
        .floating-shapes span:nth-child(2) { width:100px; height:100px; left:25%; animation-duration:10s; animation-delay:2s;   }
        .floating-shapes span:nth-child(3) { width:40px;  height:40px;  left:60%; animation-duration:6s;  animation-delay:1s;   }
        .floating-shapes span:nth-child(4) { width:80px;  height:80px;  left:75%; animation-duration:9s;  animation-delay:3s;   }
        .floating-shapes span:nth-child(5) { width:50px;  height:50px;  left:85%; animation-duration:8s;  animation-delay:0.5s; }
        @keyframes floatUp {
            0%   { transform:translateY(100vh) rotate(0deg); opacity:0; }
            10%  { opacity:.4; }
            90%  { opacity:.2; }
            100% { transform:translateY(-120px) rotate(360deg); opacity:0; }
        }

        .auth-brand { position: relative; z-index: 2; text-align: center; color: #fff; }
        .brand-icon {
            width:90px; height:90px;
            background:rgba(255,255,255,.12); backdrop-filter:blur(10px);
            border-radius:24px; display:flex; align-items:center; justify-content:center;
            font-size:2.4rem; color:var(--light-green);
            margin:0 auto 1.5rem;
            border:1px solid rgba(255,255,255,.2);
            box-shadow:0 8px 32px rgba(0,0,0,.2);
            animation:floatBrand 4s ease-in-out infinite;
        }
        @keyframes floatBrand {
            0%,100% { transform:translateY(0); }
            50%      { transform:translateY(-8px); }
        }
        .auth-brand h1 { font-size:1.85rem; font-weight:800; letter-spacing:-.5px; margin-bottom:.5rem; }
        .auth-brand p  { font-size:.88rem; opacity:.75; max-width:260px; margin:0 auto; line-height:1.6; }

        /* Step indicator */
        .step-indicator { position:relative; z-index:2; margin-top:2rem; width:100%; max-width:280px; }
        .step-item { display:flex; align-items:center; gap:.75rem; margin-bottom:.85rem; color:rgba(255,255,255,.7); font-size:.85rem; }
        .step-circle {
            width:28px; height:28px; border-radius:50%;
            display:flex; align-items:center; justify-content:center;
            font-size:.75rem; font-weight:700; flex-shrink:0;
        }
        .step-circle.active { background:var(--light-green); color:#fff; }
        .step-circle.done   { background:rgba(255,255,255,.2); color:rgba(255,255,255,.6); }

        /* RIGHT */
        .auth-right { flex:1; display:flex; align-items:center; justify-content:center; padding:2rem; }
        .auth-form-card {
            width:100%; max-width:440px;
            background:#fff; border-radius:20px;
            box-shadow:0 20px 60px rgba(0,0,0,.08);
            padding:2.5rem;
        }
        .auth-form-card h2 { font-size:1.55rem; font-weight:700; color:var(--dark-green); margin-bottom:.35rem; }
        .auth-form-card p.subtitle { color:#6c757d; font-size:.88rem; margin-bottom:1.5rem; }

        /* Progress bar */
        .progress-steps { display:flex; gap:6px; margin-bottom:1.75rem; }
        .progress-step {
            height:4px; border-radius:2px; flex:1;
            background:#e5e7eb; transition:background .3s;
        }
        .progress-step.active { background:var(--light-green); }

        .input-wrapper { position:relative; margin-bottom:1rem; }
        .input-icon {
            position:absolute; left:14px; top:50%; transform:translateY(-50%);
            color:var(--light-green); font-size:.95rem; z-index:5;
        }
        .form-control {
            border:2px solid #e8eae8; border-radius:12px;
            padding:.75rem .9rem .75rem 2.85rem;
            font-size:.9rem; transition:border-color .2s, box-shadow .2s;
        }
        .form-control:focus {
            border-color:var(--light-green);
            box-shadow:0 0 0 4px rgba(82,183,136,.15); outline:none;
        }
        .form-control::placeholder { color:#c4c9c4; }
        .password-toggle {
            position:absolute; right:14px; top:50%; transform:translateY(-50%);
            cursor:pointer; color:#9ca3af; z-index:5; background:none; border:none;
            transition:color .2s;
        }
        .password-toggle:hover { color:var(--medium-green); }

        /* Password strength */
        .pwd-strength { height:4px; border-radius:2px; margin-top:6px; transition:all .3s; }

        .btn-register {
            background:linear-gradient(135deg, var(--medium-green), var(--dark-green));
            border:none; color:#fff;
            font-weight:600; font-size:1rem; padding:.85rem;
            border-radius:12px; width:100%;
            transition:opacity .2s, transform .15s, box-shadow .2s;
            box-shadow:0 4px 15px rgba(45,106,79,.35);
        }
        .btn-register:hover {
            opacity:.92; transform:translateY(-1px);
            box-shadow:0 8px 25px rgba(45,106,79,.45); color:#fff;
        }
        .divider { text-align:center; color:#d1d5db; font-size:.85rem; margin:1.1rem 0; position:relative; }
        .divider::before, .divider::after {
            content:''; position:absolute; top:50%; width:42%; height:1px; background:#e5e7eb;
        }
        .divider::before { left:0; }
        .divider::after  { right:0; }
        .login-link { text-align:center; font-size:.88rem; color:#6c757d; }
        .login-link a { color:var(--medium-green); font-weight:600; text-decoration:none; }
        .login-link a:hover { color:var(--dark-green); text-decoration:underline; }

        .alert { border-radius:12px; font-size:.88rem; border:none; }
        .alert-danger { background:#fee2e2; color:#991b1b; }

        @media (max-width:768px) {
            .auth-left { display:none; }
            .auth-form-card { padding:2rem 1.5rem; }
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
            <p>Bergabunglah dan nikmati kemudahan booking lapangan futsal kapan saja.</p>
        </div>
        <div class="step-indicator">
            <div class="step-item">
                <div class="step-circle active">1</div>
                <span>Isi data diri Anda</span>
            </div>
            <div class="step-item">
                <div class="step-circle done">2</div>
                <span>Buat password aman</span>
            </div>
            <div class="step-item">
                <div class="step-circle done">3</div>
                <span>Mulai booking lapangan</span>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="auth-right">
        <div class="auth-form-card">
            <h2>Buat Akun Baru 🚀</h2>
            <p class="subtitle">Daftar gratis dan mulai pesan lapangan favoritmu</p>

            <!-- Progress bar visual -->
            <div class="progress-steps">
                <div class="progress-step active"></div>
                <div class="progress-step active"></div>
                <div class="progress-step active"></div>
            </div>

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

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <!-- Nama -->
                <div class="input-wrapper">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="name" id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Nama lengkap"
                           value="{{ old('name') }}" required autocomplete="name">
                </div>

                <!-- Email -->
                <div class="input-wrapper">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" id="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Alamat email"
                           value="{{ old('email') }}" required autocomplete="email">
                </div>

               <!-- Password -->
<div class="input-wrapper">
    <i class="fas fa-lock input-icon"></i>
    <input type="password" name="password" id="password"
           class="form-control"
           placeholder="Password (min. 6 karakter)"
           required oninput="checkStrength(this.value)">
    <button type="button" class="password-toggle" onclick="togglePwd('password','eye1')">
        <i class="fas fa-eye" id="eye1"></i>
    </button>
</div>
<!-- Strength bar DI LUAR wrapper -->
<div class="pwd-strength mt-1" id="strengthBar"></div>
<small id="strengthText" class="text-muted" style="font-size:.78rem;"></small>

                <!-- Konfirmasi Password -->
                <div class="input-wrapper mb-4">
                    <i class="fas fa-lock-open input-icon"></i>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="form-control"
                           placeholder="Ulangi password" required>
                    <button type="button" class="password-toggle" onclick="togglePwd('password_confirmation','eye2')">
                        <i class="fas fa-eye" id="eye2"></i>
                    </button>
                </div>

                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                </button>
            </form>

            <div class="divider">atau</div>

            <p class="login-link">
                Sudah punya akun?
                <a href="{{ route('login') }}">Login di sini</a>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePwd(id, eyeId) {
            const input = document.getElementById(id);
            const eye   = document.getElementById(eyeId);
            if (input.type === 'password') {
                input.type = 'text';
                eye.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                eye.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
        function checkStrength(val) {
            const bar  = document.getElementById('strengthBar');
            const text = document.getElementById('strengthText');
            let score = 0;
            if (val.length >= 6)  score++;
            if (val.length >= 10) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            const levels = [
                { color:'#ef4444', label:'Sangat lemah' },
                { color:'#f97316', label:'Lemah' },
                { color:'#eab308', label:'Sedang' },
                { color:'#22c55e', label:'Kuat' },
                { color:'#16a34a', label:'Sangat kuat' },
            ];
            const lvl = levels[Math.min(score, 4)];
            bar.style.background = lvl.color;
            bar.style.width = ((score / 5) * 100) + '%';
            text.textContent = val.length ? lvl.label : '';
            text.style.color = lvl.color;
        }
    </script>
</body>
</html>