<!-- Footer -->
<footer class="navbar-cafe mt-auto py-4 text-white">
    <div class="container">
        <div class="row text-center text-md-start gy-3">
            <!-- About Section -->
            <div class="col-md-5">
                <h5 class="fw-bold mb-2">☕ CAFÉ MOLINA</h5>
                <p class="small mb-0 text-white-50">
                    Sistema integral para la trazabilidad, gestión de maquila y pedidos propios de café especial. Control riguroso de trillado, curvas de tostión y despacho a clientes.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-md-3">
                <h6 class="fw-bold mb-2">Módulos Rápidos</h6>
                <ul class="list-unstyled small mb-0">
                    <li><a href="{{ route('manage.orders.index') }}" class="text-white-50 text-decoration-none hover-white">Tablero de Órdenes</a></li>
                    <li><a href="{{ route('maquila-orders.index') }}" class="text-white-50 text-decoration-none hover-white">Servicios de Maquila</a></li>
                    <li><a href="{{ route('own-orders.index') }}" class="text-white-50 text-decoration-none hover-white">Café Propio Molina</a></li>
                    <li><a href="{{ route('tostiones.index') }}" class="text-white-50 text-decoration-none hover-white">Control de Tostiones</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-md-4">
                <h6 class="fw-bold mb-2">Contacto & Soporte</h6>
                <p class="small text-white-50 mb-1">
                    <i class="fas fa-map-marker-alt me-1"></i> Planta de Beneficio y Tostión Café Molina
                </p>
                <p class="small text-white-50 mb-0">
                    <i class="fas fa-envelope me-1"></i> contacto@cafemolina.com
                </p>
            </div>
        </div>

        <hr class="border-secondary opacity-25 my-3">

        <div class="row align-items-center small text-white-50">
            <div class="col-md-6 text-center text-md-start">
                &copy; {{ date('Y') }} CAFÉ MOLINA. Todos los derechos reservados.
            </div>
            <div class="col-md-6 text-center text-md-end">
                <span>Versión 2.0 • Sistema Operativo de Planta</span>
            </div>
        </div>
    </div>
</footer>

<style>
    .hover-white:hover {
        color: #ffffff !important;
        text-decoration: underline !important;
    }
</style>

</body>
</html>
