@include('navbar')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-8">
            <div class="brand-card overflow-hidden">
                <div class="brand-header d-flex align-items-center gap-3">
                    <i class="fas fa-user-circle fa-2x"></i>
                    <div>
                        <div class="fs-5 fw-bold">Iniciar Sesión</div>
                        <div class="text-white-50 small">Acceso al Sistema Café Molina</div>
                    </div>
                </div>

                <div class="p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="admin@cafemolina.com" required autocomplete="email" autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Contraseña</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="••••••••" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3 align-items-center">
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label text-muted small" for="remember">Recordarme</label>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-muted small text-decoration-none">¿Olvidó contraseña?</a>
                                @endif
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-olive py-2 fw-bold">
                                <i class="fas fa-sign-in-alt me-1"></i> Entrar al Sistema
                            </button>
                        </div>
                    </form>

                    <div class="mt-3 text-center small text-muted">
                        Credenciales de prueba: <br>
                        <code>admin@cafemolina.com</code> / <code>password123</code>
                    </div>

                    @if (Route::has('register'))
                        <div class="text-center mt-3 text-muted small">
                            ¿No tienes cuenta? <a href="{{ route('register') }}" class="fw-bold" style="color: var(--cafe-olive);">Regístrate aquí</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('footer')
