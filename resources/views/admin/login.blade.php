<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Administrator — RSU Fikri Medika</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: #0f1f2e;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow: hidden;
        }
        .bg-pattern {
            position: fixed;
            inset: 0;
            background-image:
                radial-gradient(circle at 25% 25%, rgba(14, 124, 71, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(22, 163, 74, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }
        .login-wrap {
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 1;
        }
        .login-logo-area {
            text-align: center;
            margin-bottom: 28px;
        }
        .login-logo-area img {
            height: 44px;
            width: auto;
            object-fit: contain;
            filter: brightness(0) invert(1);
            margin-bottom: 8px;
        }
        .login-logo-area p {
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
        }
        .login-card {
            background: #172132;
            border: 1px solid #1e3248;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.4);
        }
        .login-heading {
            font-size: 20px;
            font-weight: 700;
            color: #f8fafc;
            letter-spacing: -0.02em;
            margin-bottom: 4px;
        }
        .login-sub {
            font-size: 12.5px;
            color: #64748b;
            margin-bottom: 24px;
        }
        .form-group { margin-bottom: 16px; }
        .form-label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            color: #8ba3bb;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .form-control-wrap {
            position: relative;
        }
        .form-control-wrap i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #475569;
            font-size: 13px;
            pointer-events: none;
        }
        .form-input {
            display: block;
            width: 100%;
            padding: 11px 14px 11px 38px;
            background: #0f1f2e;
            border: 1px solid #1e3248;
            border-radius: 10px;
            font-size: 13px;
            color: #e2e8f0;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .form-input::placeholder { color: #334e68; }
        .form-input:focus {
            border-color: #0e7c47;
            box-shadow: 0 0 0 3px rgba(14, 124, 71, 0.15);
        }
        .form-remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }
        .form-remember input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: #0e7c47;
            cursor: pointer;
        }
        .form-remember label {
            font-size: 12px;
            font-weight: 500;
            color: #64748b;
            cursor: pointer;
        }
        .btn-login {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #0e7c47 0%, #16a34a 100%);
            border: none;
            border-radius: 10px;
            color: #ffffff;
            font-size: 13.5px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: opacity 0.15s, transform 0.15s;
            box-shadow: 0 4px 14px rgba(14, 124, 71, 0.4);
        }
        .btn-login:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-login:active { transform: translateY(0); }
        .alert-error {
            display: flex;
            gap: 8px;
            padding: 11px 14px;
            background: rgba(225, 29, 72, 0.1);
            border: 1px solid rgba(225, 29, 72, 0.25);
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 600;
            color: #fb7185;
            margin-bottom: 18px;
        }
        .login-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 11px;
            color: #334e68;
        }
    </style>
</head>
<body>

    <div class="bg-pattern"></div>

    <div class="login-wrap">

        {{-- Logo --}}
        <div class="login-logo-area">
            <img src="{{ asset('logodasboard.png') }}" alt="RSU Fikri Medika">
            <p>Sistem Manajemen Konten</p>
        </div>

        {{-- Card --}}
        <div class="login-card">
            <h1 class="login-heading">Selamat Datang</h1>
            <p class="login-sub">Masuk ke panel administrator RSU Fikri Medika.</p>

            {{-- Error Alert --}}
            @if ($errors->any())
                <div class="alert-error">
                    <i class="fa-solid fa-circle-exclamation" style="margin-top: 1px; flex-shrink: 0;"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Alamat Email</label>
                    <div class="form-control-wrap">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autocomplete="email"
                               placeholder="admin@rsufikrimedika.com"
                               class="form-input">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="form-control-wrap">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="••••••••"
                               class="form-input">
                    </div>
                </div>

                <div class="form-remember">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ingat sesi saya</label>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Masuk ke Dashboard
                </button>
            </form>
        </div>

        <div class="login-footer">
            &copy; {{ date('Y') }} RSU Fikri Medika. All rights reserved.
        </div>

    </div>

    <script>
        window.addEventListener('pageshow', function(e) {
            if (e.persisted || (window.performance && window.performance.navigation.type === 2)) {
                window.location.reload();
            }
        });
    </script>

</body>
</html>
