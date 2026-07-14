<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Masuk atau Daftar — Tinggal Klik">
    <title>Masuk & Daftar — Tinggal Klik</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } } };</script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
            min-height: 100vh;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }
        .tab-btn {
            position: relative;
            padding: 0.75rem 2rem;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.25s ease;
            color: rgba(255,255,255,0.5);
            cursor: pointer;
            border: none;
            background: transparent;
        }
        .tab-btn.active {
            background: rgba(255,255,255,0.12);
            color: #ffffff;
            box-shadow: 0 2px 12px rgba(0,0,0,0.3);
        }
        .form-field {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.15);
            background: rgba(255,255,255,0.07);
            color: #ffffff;
            font-size: 0.875rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-field::placeholder { color: rgba(255,255,255,0.35); }
        .form-field:focus {
            border-color: rgba(99,179,237,0.6);
            box-shadow: 0 0 0 3px rgba(99,179,237,0.15);
        }
        .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 0.375rem;
        }
        .btn-primary {
            width: 100%;
            padding: 0.875rem 1.5rem;
            border-radius: 14px;
            font-size: 0.95rem;
            font-weight: 700;
            color: #ffffff;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            box-shadow: 0 4px 20px rgba(37,99,235,0.4);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 28px rgba(37,99,235,0.5);
        }
        .btn-primary:active { transform: translateY(0); }
        .error-msg {
            font-size: 0.75rem;
            color: #f87171;
            margin-top: 0.25rem;
        }
        .panel { display: none; }
        .panel.active { display: block; }
        .bg-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            pointer-events: none;
        }
    </style>
</head>
<body class="flex items-center justify-center p-4">

    <div class="bg-orb w-96 h-96 bg-blue-500 top-0 left-0 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="bg-orb w-80 h-80 bg-indigo-400 bottom-0 right-0 translate-x-1/3 translate-y-1/3"></div>
    <div class="bg-orb w-64 h-64 bg-cyan-400 top-1/2 right-1/4"></div>

    <div class="w-full max-w-md relative z-10">

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-400 to-indigo-600 shadow-xl mb-4">
                <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
            </div>
            <h1 class="text-3xl font-extrabold text-white tracking-tight">Tinggal Klik</h1>
            <p class="text-white/50 text-sm mt-1">Platform Booking Lapangan Olahraga</p>
        </div>

        <div class="glass-card rounded-3xl p-8 shadow-2xl">

            @if(session('status'))
            <div class="mb-5 p-3.5 rounded-xl bg-emerald-500/15 border border-emerald-500/25 text-emerald-300 text-sm font-medium">
                {{ session('status') }}
            </div>
            @endif

            <div class="flex gap-2 p-1.5 rounded-2xl bg-white/5 mb-7">
                <button id="tab-login" class="tab-btn active flex-1" onclick="switchTab('login')">Masuk</button>
                <button id="tab-register" class="tab-btn flex-1" onclick="switchTab('register')">Daftar</button>
            </div>

            <div id="panel-login" class="panel active">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="space-y-4">
                        <div>
                            <label for="login-email" class="form-label">Email</label>
                            <input id="login-email" type="email" name="email" value="{{ old('email') }}"
                                   class="form-field" placeholder="email@contoh.com" required autofocus autocomplete="username">
                            @error('email')
                                <p class="error-msg">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="login-password" class="form-label">Password</label>
                            <input id="login-password" type="password" name="password"
                                   class="form-field" placeholder="Kata sandi kamu" required autocomplete="current-password">
                            @error('password')
                                <p class="error-msg">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input id="remember_me" type="checkbox" name="remember"
                                       class="w-4 h-4 rounded border-white/30 bg-white/10 text-blue-500 focus:ring-blue-500 focus:ring-offset-0">
                                <span class="text-sm text-white/60">Ingat saya</span>
                            </label>
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-sm text-blue-400 hover:text-blue-300 transition-colors font-medium">
                                Lupa password?
                            </a>
                            @endif
                        </div>

                        <button type="submit" class="btn-primary mt-2">
                            Masuk ke Akun
                        </button>
                    </div>
                </form>

                <p class="text-center text-white/40 text-sm mt-6">
                    Belum punya akun?
                    <button onclick="switchTab('register')" class="text-blue-400 hover:text-blue-300 font-semibold transition-colors">Daftar sekarang</button>
                </p>
            </div>

            <div id="panel-register" class="panel">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="space-y-4">
                        <div>
                            <label for="reg-name" class="form-label">Nama Lengkap</label>
                            <input id="reg-name" type="text" name="name" value="{{ old('name') }}"
                                   class="form-field" placeholder="Nama kamu" required autocomplete="name">
                            @error('name')
                                <p class="error-msg">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="reg-email" class="form-label">Email</label>
                            <input id="reg-email" type="email" name="email" value="{{ old('email') }}"
                                   class="form-field" placeholder="email@contoh.com" required autocomplete="username">
                            @error('email')
                                <p class="error-msg">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="reg-password" class="form-label">Password</label>
                            <input id="reg-password" type="password" name="password"
                                   class="form-field" placeholder="Min. 8 karakter" required autocomplete="new-password">
                            @error('password')
                                <p class="error-msg">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="reg-password-confirm" class="form-label">Konfirmasi Password</label>
                            <input id="reg-password-confirm" type="password" name="password_confirmation"
                                   class="form-field" placeholder="Ulangi password" required autocomplete="new-password">
                        </div>

                        <button type="submit" class="btn-primary mt-2">
                            Buat Akun Gratis
                        </button>
                    </div>
                </form>

                <p class="text-center text-white/40 text-sm mt-6">
                    Sudah punya akun?
                    <button onclick="switchTab('login')" class="text-blue-400 hover:text-blue-300 font-semibold transition-colors">Masuk di sini</button>
                </p>
            </div>

        </div>

        <p class="text-center text-white/25 text-xs mt-6">
            &copy; {{ date('Y') }} Tinggal Klik. All rights reserved.
        </p>
    </div>

    <script>
    function switchTab(tab) {
        var panelLogin    = document.getElementById('panel-login');
        var panelRegister = document.getElementById('panel-register');
        var tabLogin      = document.getElementById('tab-login');
        var tabRegister   = document.getElementById('tab-register');

        if (tab === 'login') {
            panelLogin.classList.add('active');
            panelRegister.classList.remove('active');
            tabLogin.classList.add('active');
            tabRegister.classList.remove('active');
        } else {
            panelRegister.classList.add('active');
            panelLogin.classList.remove('active');
            tabRegister.classList.add('active');
            tabLogin.classList.remove('active');
        }
    }

    (function () {
        var hasRegisterErrors = {{ $errors->hasBag('default') && $errors->has('name') || $errors->has('name') ? 'true' : 'false' }};
        var registerFields = ['name', 'reg-email', 'reg-password', 'reg-password-confirm'];
        var errorKeys = @json($errors->keys());

        var registerErrorKeys = ['name', 'email', 'password'];
        var isRegisterError = false;
        for (var i = 0; i < errorKeys.length; i++) {
            if (registerErrorKeys.indexOf(errorKeys[i]) !== -1) {
                isRegisterError = true;
                break;
            }
        }

        var hasOldName = {{ old('name') ? 'true' : 'false' }};
        if (isRegisterError || hasOldName) {
            switchTab('register');
        }
    }());
    </script>
</body>
</html>
