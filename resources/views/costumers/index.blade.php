@include('navbar')

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold mb-0" style="color: var(--cafe-olive);">
                <i class="fas fa-users me-2"></i> Directorio de Clientes
            </h2>
            <p class="text-muted small mb-0">Administración de caficultores, fincas y clientes de Café Molina</p>
        </div>

        <button type="button" class="btn btn-olive" data-bs-toggle="modal" data-bs-target="#createCustomerModal">
            <i class="fas fa-user-plus me-1"></i> Nuevo Cliente
        </button>
    </div>

    <!-- Quick Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-bold">TOTAL CLIENTES</div>
                        <div class="stat-number">{{ $costumers->count() }}</div>
                    </div>
                    <div class="rounded-circle p-3" style="background: rgba(85, 107, 47, 0.1);">
                        <i class="fas fa-users fa-2x" style="color: var(--cafe-olive);"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-bold">ÓRDENES MAQUILA</div>
                        <div class="stat-number">{{ $costumers->sum('maquila_orders_count') }}</div>
                    </div>
                    <div class="rounded-circle p-3" style="background: rgba(141, 182, 0, 0.15);">
                        <i class="fas fa-industry fa-2x" style="color: var(--cafe-accent);"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-bold">PEDIDOS PROPIOS</div>
                        <div class="stat-number">{{ $costumers->sum('own_orders_count') }}</div>
                    </div>
                    <div class="rounded-circle p-3" style="background: rgba(111, 78, 55, 0.15);">
                        <i class="fas fa-coffee fa-2x" style="color: var(--cafe-brown);"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Table -->
    <div class="section-card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span>Listado de Productores y Clientes</span>
            <input type="text" id="customerSearch" class="form-control form-control-sm w-auto" placeholder="Buscar por nombre, finca o cédula...">
        </div>

        <div class="table-responsive">
            <table class="table table-styled mb-0" id="customersTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre Completo</th>
                        <th>Cédula / NIT</th>
                        <th>Teléfono</th>
                        <th>Finca / Ubicación</th>
                        <th class="text-center">Maquilas</th>
                        <th class="text-center">Pedidos Propios</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($costumers as $c)
                        <tr>
                            <td class="text-muted fw-bold">{{ $c->id }}</td>
                            <td class="fw-bold text-dark">{{ $c->name }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $c->cedula }}</span></td>
                            <td>
                                <a href="tel:{{ $c->phone }}" class="text-decoration-none text-muted">
                                    <i class="fas fa-phone-alt me-1 text-success"></i> {{ $c->phone }}
                                </a>
                            </td>
                            <td>
                                <i class="fas fa-map-marker-alt me-1 text-danger"></i> {{ $c->farm ?: 'No especificada' }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-secondary">{{ $c->maquila_orders_count ?? 0 }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge" style="background-color: var(--cafe-olive);">{{ $c->own_orders_count ?? 0 }}</span>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-warning" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editCustomerModal{{ $c->id }}"
                                    title="Editar Cliente">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>

                                <form action="{{ route('costumers.destroy', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar este cliente? Se eliminarán también sus órdenes asociadas.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit Customer -->
                        <div class="modal fade" id="editCustomerModal{{ $c->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header text-white" style="background: var(--cafe-olive);">
                                        <h5 class="modal-title fw-bold">Editar Cliente #{{ $c->id }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('costumers.update', $c->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nombre Completo</label>
                                                <input type="text" name="name" class="form-control" value="{{ $c->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Cédula o NIT</label>
                                                <input type="text" name="cedula" class="form-control" value="{{ $c->cedula }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Teléfono de Contacto</label>
                                                <input type="text" name="phone" class="form-control" value="{{ $c->phone }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Finca / Vereda</label>
                                                <input type="text" name="farm" class="form-control" value="{{ $c->farm }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-olive">Actualizar Cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="fas fa-users-slash fa-2x mb-2 d-block text-secondary"></i>
                                No hay clientes registrados aún. ¡Crea el primero con el botón superior!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Create Customer -->
<div class="modal fade" id="createCustomerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: var(--cafe-olive);">
                <h5 class="modal-title fw-bold"><i class="fas fa-user-plus me-1"></i> Registrar Nuevo Cliente</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('costumers.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre Completo</label>
                        <input type="text" name="name" class="form-control" placeholder="Ej: Carlos Alberto Restrepo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Cédula o NIT</label>
                        <input type="text" name="cedula" class="form-control" placeholder="Ej: 1002345678" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Teléfono de Contacto</label>
                        <input type="text" name="phone" class="form-control" placeholder="Ej: +57 310 456 7890" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Finca / Vereda</label>
                        <input type="text" name="farm" class="form-control" placeholder="Ej: Finca La Primavera - Vereda El Roble" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-olive"><i class="fas fa-save me-1"></i> Guardar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('customerSearch').addEventListener('input', function() {
    const term = this.value.toLowerCase();
    const rows = document.querySelectorAll('#customersTable tbody tr');
    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(term) ? '' : 'none';
    });
});
</script>

@include('footer')
