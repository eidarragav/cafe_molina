@include('navbar')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="brand-card overflow-hidden">
                <div class="brand-header d-flex align-items-center gap-3">
                    <i class="fas fa-user-plus fa-2x"></i>
                    <div>
                        <div class="fs-5 fw-bold">Crear Cuenta</div>
                        <div class="text-white-50 small">Registro de operario / personal en Café Molina</div>
                    </div>
                </div>

                <div class="p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nombre Completo</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Ej: Diana Valencia" required autocomplete="name" autofocus>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="diana@cafemolina.com" required autocomplete="email">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-bold">Contraseña</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password-confirm" class="form-label fw-bold">Confirmar contraseña</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-olive py-2 fw-bold">
                                <i class="fas fa-user-check me-1"></i> Completar Registro
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3 text-muted small">
                        ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="fw-bold" style="color: var(--cafe-olive);">Inicia sesión aquí</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('footer')
