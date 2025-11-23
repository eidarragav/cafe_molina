<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Login - CAFEMOLINA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body { background: #f7faf4; font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }
        .brand-card {
            border-left: 6px solid #556B2F; /* olive drab */
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 6px 18px rgba(85, 107, 47, 0.15);
        }
        .brand-header {
            background-color: #556B2F;
            color: white;
            padding: 24px;
            border-radius: 8px 8px 0 0;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .brand-header i {
            font-size: 2rem;
            color: #A9BA9D; /* lighter olive hue */
        }
        .form-label {
            color: #556B2F;
            font-weight: 600;
        }
        .btn-olive {
            background-color: #556B2F;
            color: white;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-olive:hover, .btn-olive:focus {
            background-color: #8DB600;
            color: white;
        }
        .small-muted {
            color: #6c6c6c;
        }
    </style>
</head>
<body>

@include('navbar')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="cafe-card overflow-hidden">
                <div class="cafe-header d-flex align-items-center gap-3">
                    <i class="fas fa-user-circle fa-2x"></i>
                    <div>
                        <div style="font-size:1.1rem">Iniciar sesión</div>
                        <div class="small-muted" style="font-size:.9rem">Accede a tu panel de gestión</div>
                    </div>
                </div>

                <div class="p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3 align-items-center">
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label small-muted" for="remember">Recordarme</label>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="small-muted">¿Olvidaste tu contraseña?</a>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-cafe w-100">Entrar</button>
                        </div>
                    </form>

                    <div class="text-center mt-3 small-muted">
                        ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('footer')

</body>
</html>
