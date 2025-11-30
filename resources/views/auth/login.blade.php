<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - QuickCart</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --text: #374151;
            --text-light: #6b7280;
            --border: #d1d5db;
            --bg-light: #f9fafb;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
            border: 1px solid var(--border);
        }

        .login-header {
            background: white;
            padding: 2rem 1.5rem 1rem;
            text-align: center;
            border-bottom: 1px solid var(--border);
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: var(--text);
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .logo span {
            color: var(--primary);
        }

        .login-header h1 {
            color: var(--text);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: var(--text-light);
            margin-bottom: 0;
            font-size: 0.9rem;
        }

        .login-body {
            padding: 1.5rem;
        }

        .form-control {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-label {
            color: var(--text);
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .btn-login {
            background: var(--primary);
            border: none;
            color: white;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.2s ease;
            width: 100%;
        }

        .btn-login:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .form-check-label {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .forgot-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .forgot-link:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        .session-status {
            background: #dbeafe;
            border: 1px solid #bfdbfe;
            color: var(--text);
            padding: 0.75rem 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .input-error {
            color: #dc2626;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        .signup-link {
            text-align: center;
            color: var(--text-light);
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .signup-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-container mx-auto">
                    <!-- Header -->
                    <div class="login-header">
                        <a class="logo" href="{{ url('/') }}">
                            <span>BIxBO Store</span>
                        </a>
                        <h1>Masuk ke Akun</h1>
                        <p>Selamat datang kembali</p>
                    </div>

                    <!-- Body -->
                    <div class="login-body">
                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="session-status">
                                <i class="fas fa-info-circle me-2"></i>
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@contoh.com">
                                @error('email')
                                    <div class="input-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan password">
                                @error('password')
                                    <div class="input-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                    <label class="form-check-label" for="remember_me">
                                        Ingat saya
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                                @endif
                            </div>

                            <!-- Login Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn-login">
                                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                                </button>
                            </div>
                        </form>

                        <!-- Additional Links -->
                        <div class="signup-link">
                            <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
