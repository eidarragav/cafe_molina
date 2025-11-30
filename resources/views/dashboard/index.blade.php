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

<div class="section-card mt-4 mb-4">
    <div class="card-header">
        Productos más vendidos
    </div>
    <div class="card-body p-0">
        <table class="table table-styled">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Pedidos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productsStats as $p)
                    <tr>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<div class="section-card mt-4">
    <div class="card-header">
        Clientes con más pedidos
    </div>
    <div class="card-body p-0">
        <table class="table table-styled">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Pedidos Totales</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customersOrders as $c)
                    <tr>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
                <canvas id="productsChart" style="max-width: 100%;"></canvas>
            </div>
        </div>

    </div>

    <div class="row g-4 mt-4">

    <div class="col-md-6">
        <div class="chart-box">
            <div class="section-title mb-3">Pedidos Generales</div>
            <canvas id="generalOrdersChart"></canvas>
        </div>
    </div>

    <div class="col-md-6">
        <div class="chart-box">
            <div class="section-title mb-3">Estado de Pedidos</div>
            <canvas id="statusChart"></canvas>
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
                    label: 'CafeMolina',
                    data: ownData
                },
                {
                    label: 'Maquila',
                    data: maquilaData
                }
            ]
        }
    });

    
    const ctx2 = document.getElementById('productsChart');
    new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['CafeMolina', 'Maquila'],
            datasets: [{
                data: [{{$ownOrders}}, {{$maquilaOrders}}]
            }]
        }
    });

    const ctx3 = document.getElementById('generalOrdersChart');

    new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: ['CafeMolina', 'Maquila'],
        datasets: [{
            data: [{{$ownOrders}}, {{$maquilaOrders}}],
            label: 'Total Pedidos ',
            backgroundColor: ['#3b82f6','#FFB6C1'] // azul y rosado
        }]
    }
    });



    const ctx4 = document.getElementById('statusChart');

    new Chart(ctx4, {
    type: 'bar',
    data: {
        labels: ['En proceso', 'Terminados'],
        datasets: [{
            data: [{{$incompleted}}, {{$completedOrders}}],
            label: 'Estados',
            backgroundColor: ['#3b82f6','#FFB6C1'] // azul y rosado
        }]
    }
    });


</script>

</body>
</html>
@include("footer")