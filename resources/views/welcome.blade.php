@include("navbar")

<div class="container my-5">
    <!-- Hero Banner -->
    <div class="card p-5 text-white mb-5 shadow-lg border-0" style="background: linear-gradient(135deg, #556B2F 0%, #35471d 100%); border-radius: 20px;">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge px-3 py-2 mb-3 text-uppercase fw-bold" style="background: rgba(141, 182, 0, 0.4); border: 1px solid #8DB600;">
                    <i class="fas fa-leaf me-1"></i> Especialistas en Café de Origen & Maquila
                </span>
                <h1 class="display-4 fw-bold mb-3">CAFÉ MOLINA</h1>
                <p class="lead mb-4 text-white-50" style="max-width: 680px;">
                    Plataforma integral de gestión operativa cafetera: trazabilidad de lotes, control de trillado por mallas, curvas de tostión artesanal, formulación de empaque y seguimiento en tiempo real.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    @auth
                        <a href="{{ route('manage.orders.index') }}" class="btn btn-lg btn-light fw-bold px-4 py-3 text-success shadow-sm">
                            <i class="fas fa-tasks me-2"></i> Ir al Tablero de Órdenes
                        </a>
                        <a href="{{ route('maquila-orders.index') }}" class="btn btn-lg btn-outline-light fw-bold px-4 py-3">
                            <i class="fas fa-plus-circle me-2"></i> Nueva Orden Maquila
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-lg btn-light fw-bold px-4 py-3 text-success shadow-sm">
                            <i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión en Planta
                        </a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-lg btn-outline-light fw-bold px-4 py-3">
                                <i class="fas fa-user-plus me-2"></i> Registrarse
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <div class="p-4 rounded-circle d-inline-block shadow" style="background: rgba(255,255,255,0.08); border: 2px dashed rgba(255,255,255,0.3);">
                    <i class="fas fa-mug-hot fa-7x" style="color: #F8E7D3;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Core Operations Grid -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 p-4 shadow-sm border-0 transition-hover">
                <div class="rounded-circle p-3 mb-3 d-inline-block" style="background: rgba(85, 107, 47, 0.12);">
                    <i class="fas fa-industry fa-2x" style="color: var(--cafe-olive);"></i>
                </div>
                <h4 class="fw-bold mb-2">Servicios de Maquila</h4>
                <p class="text-muted small mb-4">
                    Recepción técnica de café pergamino seco (CPS), densidades, humedades, clasificación por mallas (18, 17, 15, 14, fondo) y servicios a la medida del caficultor.
                </p>
                <div class="mt-auto">
                    <a href="{{ route('maquila-orders.index') }}" class="btn btn-sm btn-olive">
                        Gestionar Maquilas <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 p-4 shadow-sm border-0 transition-hover">
                <div class="rounded-circle p-3 mb-3 d-inline-block" style="background: rgba(111, 78, 55, 0.12);">
                    <i class="fas fa-coffee fa-2x" style="color: var(--cafe-brown);"></i>
                </div>
                <h4 class="fw-bold mb-2">Línea Café Molina</h4>
                <p class="text-muted small mb-4">
                    Elaboración y despacho de pedidos de café de marca propia en grano o molido, con estimación algorítmica de materia prima verde y control de inventario.
                </p>
                <div class="mt-auto">
                    <a href="{{ route('own-orders.index') }}" class="btn btn-sm btn-cafe">
                        Gestionar Pedidos Propios <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 p-4 shadow-sm border-0 transition-hover">
                <div class="rounded-circle p-3 mb-3 d-inline-block" style="background: rgba(141, 182, 0, 0.15);">
                    <i class="fas fa-fire fa-2x" style="color: var(--cafe-accent);"></i>
                </div>
                <h4 class="fw-bold mb-2">Control de Tostión</h4>
                <p class="text-muted small mb-4">
                    Registro sistemático por batch de peso inicial, peso tostado final y cálculo instantáneo de mermas para garantizar perfiles de taza homogéneos.
                </p>
                <div class="mt-auto">
                    <a href="{{ route('tostiones.index') }}" class="btn btn-sm btn-outline-success">
                        Ver Tostiones <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Production Pipeline / Process Flow -->
    <div class="section-card p-4">
        <h4 class="fw-bold mb-4 text-center" style="color: var(--cafe-olive);">
            <i class="fas fa-project-diagram me-2"></i> Flujo Operativo en Planta de Beneficio y Tostión
        </h4>

        <div class="row text-center g-3">
            <div class="col-md">
                <div class="p-3 border rounded h-100 bg-light">
                    <div class="fw-bold text-success mb-1">01. Recepción</div>
                    <div class="small text-muted">Pesaje bruto, tara de empaque (bulto/estopa), humedad y densidad verde.</div>
                </div>
            </div>
            <div class="col-md">
                <div class="p-3 border rounded h-100 bg-light">
                    <div class="fw-bold text-success mb-1">02. Trillado & Mallas</div>
                    <div class="small text-muted">Separación por tamices granulométricos (M18, M17, M15, M14, Fondo).</div>
                </div>
            </div>
            <div class="col-md">
                <div class="p-3 border rounded h-100 bg-light">
                    <div class="fw-bold text-success mb-1">03. Curva Tostión</div>
                    <div class="small text-muted">Perfil de tostado (Bajo, Medio, Alto) y registro estricto de mermas.</div>
                </div>
            </div>
            <div class="col-md">
                <div class="p-3 border rounded h-100 bg-light">
                    <div class="fw-bold text-success mb-1">04. Empaquetado</div>
                    <div class="small text-muted">Molienda o grano entero, válvulas desgasificadoras y presentaciones.</div>
                </div>
            </div>
            <div class="col-md">
                <div class="p-3 border rounded h-100 bg-light">
                    <div class="fw-bold text-success mb-1">05. Despacho & PDF</div>
                    <div class="small text-muted">Generación de remisiones oficiales en PDF y entrega a conformidad.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.transition-hover {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.transition-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.1) !important;
}
</style>

@include("footer")
