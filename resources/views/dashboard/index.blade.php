<!-- Dashboard Template (static, no variables yet) -->
@include('navbar')


<div class="container py-4">

    <h1 class="mb-4">Dashboard de Gestión Cafe Molina</h1>

    <!-- Stat cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card p-3">
                <h3>Pedidos Maquila</h3>
                <div class="stat-number">{{$maquilaOrders ?? 'No hay datos'}}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h3>Pedidos Propios</h3>
                <div class="stat-number">{{$ownOrders ?? 'No hay datos' }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h3>En Proceso</h3>
                <div class="stat-number">{{$incompleted ?? 'No hay datos' }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h3>Kilos Totales</h3>
                <div class="stat-number">{{$kilosTotal ?? 'No hay datos'}}</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card p-3">
                <h3>Urgentes</h3>
                <div class="stat-number">{{$urgentOrders ?? 'No hay datos'}}</div>
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
                <div class="stat-number">{{$topProduct->name ?? 'No hay datos'}}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h3>Pedidos Completados</h3>
                <div class="stat-number">{{$completedOrders ?? 'No hay datos'}}</div>
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
    const months = @json($months);
    const ownData = @json($ownData);
    const maquilaData = @json($maquilaData);

    const monthNames = ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];
    const labels = months.map(m => monthNames[m - 1]);

    const ctx1 = document.getElementById('ordersChart');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Own Orders',
                    data: ownData
                },
                {
                    label: 'Maquila Orders',
                    data: maquilaData
                }
            ]
        }
    });

    
    const ctx2 = document.getElementById('productsChart');
    new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Own Orders', 'Maquila'],
            datasets: [{
                data: [{{$ownOrders}}, {{$maquilaOrders}}]
            }]
        }
    });
</script>

</body>
</html>
