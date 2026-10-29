@include('navbar')

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold mb-0" style="color: var(--cafe-olive);">
                <i class="fas fa-users-cog me-2"></i> Gestión de Usuarios y Equipo
            </h2>
            <p class="text-muted small mb-0">Control de acceso y operarios autorizados en la planta Café Molina</p>
        </div>

        <button type="button" class="btn btn-olive" data-bs-toggle="modal" data-bs-target="#createUserModal">
            <i class="fas fa-user-plus me-1"></i> Registrar Usuario
        </button>
    </div>

    <div class="section-card">
        <div class="card-header">Equipo de Trabajo y Operarios</div>
        <div class="table-responsive">
            <table class="table table-styled mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                        <th class="text-center">Órdenes Maquila</th>
                        <th class="text-center">Pedidos Propios</th>
                        <th>Fecha de Registro</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                        <tr>
                            <td class="text-muted fw-bold">{{ $u->id }}</td>
                            <td class="fw-bold">
                                {{ $u->name }}
                                @if(auth()->id() === $u->id)
                                    <span class="badge bg-success ms-1">Tú</span>
                                @endif
                            </td>
                            <td>{{ $u->email }}</td>
                            <td class="text-center">
                                <span class="badge bg-secondary">{{ $u->maquila_orders_count }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge" style="background-color: var(--cafe-olive);">{{ $u->own_orders_count }}</span>
                            </td>
                            <td>{{ $u->created_at ? $u->created_at->format('d/m/Y') : 'N/A' }}</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-warning" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editUserModal{{ $u->id }}"
                                    title="Editar Usuario">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>

                                @if(auth()->id() !== $u->id)
                                    <form action="{{ route('users.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>

                        <!-- Edit User Modal -->
                        <div class="modal fade" id="editUserModal{{ $u->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header text-white" style="background: var(--cafe-olive);">
                                        <h5 class="modal-title fw-bold">Editar Usuario #{{ $u->id }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('users.update', $u->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nombre Completo</label>
                                                <input type="text" name="name" class="form-control" value="{{ $u->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Correo Electrónico</label>
                                                <input type="email" name="email" class="form-control" value="{{ $u->email }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nueva Contraseña (Opcional)</label>
                                                <input type="password" name="password" class="form-control" placeholder="Dejar en blanco para conservar la actual">
                                                <div class="form-text">Mínimo 6 caracteres</div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-olive">Actualizar Usuario</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: var(--cafe-olive);">
                <h5 class="modal-title fw-bold"><i class="fas fa-user-plus me-1"></i> Registrar Operario / Usuario</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre Completo</label>
                        <input type="text" name="name" class="form-control" placeholder="Ej: Carlos López" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" placeholder="Ej: carlos@cafemolina.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Contraseña</label>
                        <input type="password" name="password" class="form-control" placeholder="Mínimo 6 caracteres" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-olive"><i class="fas fa-save me-1"></i> Guardar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('footer')
