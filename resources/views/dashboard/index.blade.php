<!-- Dashboard Template (static, no variables yet) -->
@include('navbar')


<div class="container py-4">

    <h1 class="mb-4">Dashboard de Gestión Cafe Molina</h1>

    <!-- Stat cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card p-3">
                <h3>Pedidos Maquila</h3>
                <div class="stat-number">{{$maquilaOrders}}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h3>Pedidos Propios</h3>
                <div class="stat-number">{{$ownOrders}}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h3>En Proceso</h3>
                <div class="stat-number">{{$incompleted}}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h3>Kilos Totales</h3>
                <div class="stat-number">{{$kilosTotal}}</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card p-3">
                <h3>Urgentes</h3>
                <div class="stat-number">{{$urgentOrders}}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h3>Cliente con más pedidos</h3>
                <div class="stat-number">{{$topCustomer->name ?? 'No hay datos'}}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h3>Producto más vendido</h3>
                <div class="stat-number">{{$topProduct->name}}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h3>Pedidos Completados</h3>
                <div class="stat-number">{{$completedOrders}}</div>
            </div>
        </div>
    </div>

    <!-- Charts & Tables section -->
    <div class="row g-4">

        <div class="col-md-6">
            <div class="chart-box">
                <div class="section-title mb-3">Pedidos por Mes</div>
                <canvas id="ordersChart"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="chart-box">
                <div class="section-title mb-3">Distribución de Productos</div>
                <canvas id="productsChart"></canvas>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx1 = document.getElementById('ordersChart');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Jul', 'Ago', 'Sep', 'Oct', 'Nov'],
            datasets: [{
                label: 'Pedidos',
                data: [10, 12, 8, 14, 20]
            }]
        }
    });

    const ctx2 = document.getElementById('productsChart');
    new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Own Orders', 'Maquila'],
            datasets: [{
                data: [35, 65]
            }]
        }
    });
</script>

</body>
</html>
