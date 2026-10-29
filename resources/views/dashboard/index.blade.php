@include('navbar')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold mb-0" style="color: var(--cafe-olive);">
                <i class="fas fa-chart-line me-2"></i> Panel de Métricas & Dashboard
            </h2>
            <p class="text-muted small mb-0">Rendimiento global de planta, volumen de café procesado y analítica de ventas</p>
        </div>
        <div class="text-muted small">
            <i class="fas fa-clock me-1"></i> Actualizado en tiempo real
        </div>
    </div>

    <!-- Stat cards: Row 1 -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card p-3 shadow-sm h-100">
                <div class="text-muted small fw-bold">ÓRDENES MAQUILA</div>
                <div class="stat-number">{{ $maquilaOrders ?? 0 }}</div>
                <div class="small text-muted">Lotes de productores externos</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card p-3 shadow-sm h-100">
                <div class="text-muted small fw-bold">PEDIDOS CAFÉ MOLINA</div>
                <div class="stat-number" style="color: var(--cafe-brown);">{{ $ownOrders ?? 0 }}</div>
                <div class="small text-muted">Despachos de marca propia</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card p-3 shadow-sm h-100">
                <div class="text-muted small fw-bold">EN PROCESO</div>
                <div class="stat-number text-warning">{{ $incompleted ?? 0 }}</div>
                <div class="small text-muted">Lotes activos en planta</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card p-3 shadow-sm h-100">
                <div class="text-muted small fw-bold">COMPLETADOS</div>
                <div class="stat-number text-success">{{ $completedOrders ?? 0 }}</div>
                <div class="small text-muted">Listos para entrega / despacho</div>
            </div>
        </div>
    </div>

    <!-- Stat cards: Row 2 -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card p-3 shadow-sm h-100">
                <div class="text-muted small fw-bold">KILOS TOTALES PROCESADOS</div>
                <div class="stat-number" style="color: var(--cafe-accent);">{{ number_format($kilosTotal ?? 0, 1) }} kg</div>
                <div class="small text-muted">
                    Maquila: {{ number_format($kilosMaquila ?? 0, 1) }} kg • Propio: {{ number_format($kilosOwn ?? 0, 1) }} kg
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card p-3 shadow-sm h-100">
                <div class="text-muted small fw-bold">PEDIDOS URGENTES</div>
                <div class="stat-number text-danger">{{ $urgentOrders ?? 0 }}</div>
                <div class="small text-muted">Con prioridad de entrega</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card p-3 shadow-sm h-100">
                <div class="text-muted small fw-bold">CLIENTE TOP</div>
                <div class="fs-4 fw-bold text-dark mt-2 text-truncate" title="{{ $topCustomer->name ?? 'Sin registros' }}">
                    {{ $topCustomer->name ?? 'Sin registros' }}
                </div>
                <div class="small text-muted">{{ $topCustomer->total ?? 0 }} pedidos registrados</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card p-3 shadow-sm h-100">
                <div class="text-muted small fw-bold">PRODUCTO MÁS VENDIDO</div>
                <div class="fs-4 fw-bold text-dark mt-2 text-truncate" title="{{ $topProduct->name ?? 'Sin registros' }}">
                    {{ $topProduct->name ?? 'Sin registros' }}
                </div>
                <div class="small text-muted">{{ $topProduct->total ?? 0 }} unidades vendidas</div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="chart-box">
                <div class="section-title mb-3">
                    <i class="fas fa-calendar-alt me-1"></i> Evolución Mensual de Pedidos
                </div>
                <canvas id="ordersChart" style="height: 250px;"></canvas>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="chart-box">
                <div class="section-title mb-3">
                    <i class="fas fa-chart-pie me-1"></i> Proporción de Líneas
                </div>
                <canvas id="productsChart" style="height: 250px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="chart-box">
                <div class="section-title mb-3">
                    <i class="fas fa-layer-group me-1"></i> Estado del Flujo de Producción
                </div>
                <canvas id="statusChart" style="height: 220px;"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="chart-box">
                <div class="section-title mb-3">
                    <i class="fas fa-balance-scale me-1"></i> Distribución de Pedidos por Canal
                </div>
                <canvas id="generalOrdersChart" style="height: 220px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="section-card">
                <div class="card-header">
                    <i class="fas fa-trophy me-1"></i> Productos Propios Más Solicitados
                </div>
                <div class="table-responsive">
                    <table class="table table-styled mb-0">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th class="text-end">Pedidos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productsStats as $p)
                                <tr>
                                    <td>{{ $p->name }}</td>
                                    <td class="text-end"><span class="badge bg-secondary">{{ $p->total }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted py-3">No hay productos registrados aún.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="section-card">
                <div class="card-header">
                    <i class="fas fa-star me-1"></i> Clientes con Mayor Frecuencia de Pedidos
                </div>
                <div class="table-responsive">
                    <table class="table table-styled mb-0">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th class="text-end">Total Pedidos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customersOrders as $c)
                                <tr>
                                    <td>{{ $c->name }}</td>
                                    <td class="text-end"><span class="badge" style="background: var(--cafe-olive);">{{ $c->total }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted py-3">No hay clientes con pedidos aún.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
    const labels = months.length > 0 ? months.map(m => monthNames[m - 1]) : ['Sin datos'];

    // 1. Bar Chart: Orders by Month
    const ctx1 = document.getElementById('ordersChart');
    if (ctx1) {
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Café Molina',
                        data: ownData.length > 0 ? ownData : [0],
                        backgroundColor: '#6f4e37'
                    },
                    {
                        label: 'Maquila',
                        data: maquilaData.length > 0 ? maquilaData : [0],
                        backgroundColor: '#556B2F'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });
    }

    // 2. Pie Chart: Own vs Maquila
    const ctx2 = document.getElementById('productsChart');
    if (ctx2) {
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Café Molina', 'Maquila'],
                datasets: [{
                    data: [{{ $ownOrders ?? 0 }}, {{ $maquilaOrders ?? 0 }}],
                    backgroundColor: ['#6f4e37', '#556B2F']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });
    }

    // 3. Bar Chart: General orders
    const ctx3 = document.getElementById('generalOrdersChart');
    if (ctx3) {
        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: ['Café Molina', 'Maquila'],
                datasets: [{
                    label: 'Total Pedidos',
                    data: [{{ $ownOrders ?? 0 }}, {{ $maquilaOrders ?? 0 }}],
                    backgroundColor: ['#6f4e37', '#556B2F']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });
    }

    // 4. Bar Chart: Status
    const ctx4 = document.getElementById('statusChart');
    if (ctx4) {
        new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: ['En Proceso', 'Terminados'],
                datasets: [{
                    label: 'Cantidad de Lotes',
                    data: [{{ $incompleted ?? 0 }}, {{ $completedOrders ?? 0 }}],
                    backgroundColor: ['#eab308', '#22c55e']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });
    }
</script>

@include("footer")
