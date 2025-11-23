<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Registro - CAFEMOLINA</title>

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
        <div class="col-lg-7 col-md-9">
            <div class="brand-card overflow-hidden">
                <div class="brand-header d-flex align-items-center gap-3">
                    <i class="fas fa-user-plus fa-2x"></i>
                    <div>
                        <div style="font-size:1.1rem">Crear cuenta</div>
                        <div class="small-muted" style="font-size:.9rem">Regístrate para gestionar pedidos</div>
                    </div>
                </div>

                <div class="p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password-confirm" class="form-label">Confirmar contraseña</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-olive w-100">Registrarme</button>
                        </div>
                    </form>

                    <div class="text-center mt-3 small-muted">
                        ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('footer')

</body>
</html>
