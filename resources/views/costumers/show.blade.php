@include('navbar')

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <a href="{{ route('costumers.index') }}" class="btn btn-sm btn-outline-secondary mb-2">
                <i class="fas fa-arrow-left me-1"></i> Volver a Clientes
            </a>
            <h2 class="fw-bold mb-0" style="color: var(--cafe-olive);">
                <i class="fas fa-user-check me-2"></i> {{ $costumer->name }}
            </h2>
            <span class="badge bg-light text-dark border">Cédula: {{ $costumer->cedula }}</span>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card p-3 shadow-sm h-100">
                <h5 class="fw-bold text-olive mb-3" style="color: var(--cafe-olive);">Información de Contacto</h5>
                <p class="mb-2"><strong>Teléfono:</strong> {{ $costumer->phone }}</p>
                <p class="mb-2"><strong>Finca / Ubicación:</strong> {{ $costumer->farm ?: 'No especificada' }}</p>
                <p class="mb-0"><strong>Registrado desde:</strong> {{ $costumer->created_at ? $costumer->created_at->format('d/m/Y') : 'N/A' }}</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 shadow-sm h-100">
                <h5 class="fw-bold mb-3" style="color: var(--cafe-olive);">Pedidos de Maquila</h5>
                <div class="stat-number">{{ $costumer->maquila_orders->count() }}</div>
                <p class="text-muted small mb-0">Total órdenes procesadas en planta</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 shadow-sm h-100">
                <h5 class="fw-bold mb-3" style="color: var(--cafe-olive);">Pedidos Café Molina</h5>
                <div class="stat-number">{{ $costumer->own_orders->count() }}</div>
                <p class="text-muted small mb-0">Total pedidos propios despachados</p>
            </div>
        </div>
    </div>

    <!-- Maquila Orders History -->
    <div class="section-card">
        <div class="card-header">Historial de Órdenes de Maquila</div>
        <div class="table-responsive">
            <table class="table table-styled mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha Entrada</th>
                        <th>Fecha Salida</th>
                        <th>Tipo Café</th>
                        <th>Kilos Recibidos</th>
                        <th>Kilos Netos</th>
                        <th>Estado</th>
                        <th class="text-end">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($costumer->maquila_orders as $m)
                        <tr>
                            <td>#{{ $m->id }}</td>
                            <td>{{ $m->entry_date }}</td>
                            <td>{{ $m->departure_date ?: 'En cálculo' }}</td>
                            <td>{{ ucfirst($m->coffe_type) }}</td>
                            <td>{{ $m->recieved_kilograms }} kg</td>
                            <td>{{ $m->net_weight }} kg</td>
                            <td><span class="badge bg-secondary">{{ ucfirst($m->status) }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('maquila.orders.show', $m->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('maquila.pdf', $m->id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-3 text-muted">No tiene órdenes de maquila registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Own Orders History -->
    <div class="section-card">
        <div class="card-header">Historial de Pedidos Propios (Café Molina)</div>
        <div class="table-responsive">
            <table class="table table-styled mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha Entrada</th>
                        <th>Fecha Salida</th>
                        <th>Urgente</th>
                        <th>Estado</th>
                        <th class="text-end">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($costumer->own_orders as $o)
                        <tr>
                            <td>#{{ $o->id }}</td>
                            <td>{{ $o->entry_date }}</td>
                            <td>{{ $o->departure_date ?: 'En cálculo' }}</td>
                            <td>
                                @if($o->urgent_order === 'yes')
                                    <span class="badge bg-danger">Sí</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td><span class="badge bg-secondary">{{ ucfirst($o->status) }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('own-orders.show', $o->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('own.pdf', $o->id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-3 text-muted">No tiene pedidos propios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('footer')
