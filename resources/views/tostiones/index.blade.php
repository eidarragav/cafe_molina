@include('navbar')

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold mb-0" style="color: var(--cafe-olive);">
                <i class="fas fa-fire me-2"></i> Control de Tostiones & Mermas
            </h2>
            <p class="text-muted small mb-0">Registro riguroso de curvas de tostión, peso verde inicial, peso tostado y merma</p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-bold">PEDIDOS PROPIOS ACTIVOS</div>
                        <div class="stat-number">{{ $ownOrders->count() }}</div>
                    </div>
                    <div class="rounded-circle p-3" style="background: rgba(111, 78, 55, 0.15);">
                        <i class="fas fa-coffee fa-2x" style="color: var(--cafe-brown);"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-bold">ÓRDENES DE MAQUILA ACTIVAS</div>
                        <div class="stat-number">{{ $maquilaOrders->count() }}</div>
                    </div>
                    <div class="rounded-circle p-3" style="background: rgba(85, 107, 47, 0.12);">
                        <i class="fas fa-industry fa-2x" style="color: var(--cafe-olive);"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección Pedidos Propios -->
    <div class="section-card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--cafe-brown);">
            <span><i class="fas fa-coffee me-2"></i> Pedidos Propios (Café Molina)</span>
            <span class="badge bg-light text-dark">{{ $ownOrders->count() }}</span>
        </div>
        <div class="card-body p-3">
            @if($ownOrders->isEmpty())
                <p class="text-muted text-center py-3 mb-0">No hay pedidos propios registrados.</p>
            @else
                <div class="list-group">
                    @foreach($ownOrders as $order)
                        <div class="list-group-item p-3 mb-3 border rounded shadow-sm">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div>
                                    <div class="fw-bold fs-6">
                                        <span class="badge" style="background: var(--cafe-brown);">Pedido #{{ $order->id }}</span>
                                        {{ $order->costumer->name ?? 'Cliente N/A' }}
                                    </div>
                                    <div class="small text-muted">
                                        <i class="fas fa-user-circle me-1"></i> Operario: {{ $order->user->name ?? 'N/A' }} • 
                                        <i class="fas fa-calendar-alt me-1"></i> Fecha: {{ $order->entry_date ? \Carbon\Carbon::parse($order->entry_date)->format('d/m/Y') : '—' }}
                                    </div>
                                </div>

                                <button class="btn btn-sm btn-olive"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#toastFormOwn{{ $order->id }}">
                                    <i class="fas fa-plus-circle me-1"></i> Añadir Tostión
                                </button>
                            </div>

                            <!-- Collapse Form -->
                            <div class="collapse mt-3" id="toastFormOwn{{ $order->id }}">
                                <form action="{{ route('toasts.store') }}" method="POST" class="p-3 bg-light rounded border">
                                    @csrf
                                    <input type="hidden" name="own_order_id" value="{{ $order->id }}">

                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Peso Inicial Verde (kg)</label>
                                            <input id="startW_own_{{ $order->id }}" 
                                                   type="number" step="0.01" min="0" 
                                                   name="start_weight" class="form-control" 
                                                   oninput="calcMerma('startW_own_{{ $order->id }}', 'finalW_own_{{ $order->id }}', 'decrease_own_{{ $order->id }}')" 
                                                   placeholder="Ej: 50.00" required>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Peso Final Tostado (kg)</label>
                                            <input id="finalW_own_{{ $order->id }}" 
                                                   type="number" step="0.01" min="0" 
                                                   name="final_weight" class="form-control" 
                                                   oninput="calcMerma('startW_own_{{ $order->id }}', 'finalW_own_{{ $order->id }}', 'decrease_own_{{ $order->id }}')" 
                                                   placeholder="Ej: 41.50" required>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Merma Calculada (kg)</label>
                                            <input id="decrease_own_{{ $order->id }}" 
                                                   type="number" step="0.01" 
                                                   name="decrease" class="form-control bg-white" 
                                                   placeholder="0.00" readonly required>
                                        </div>
                                    </div>

                                    <div class="mt-3 text-end">
                                        <button type="submit" class="btn btn-sm btn-olive">
                                            <i class="fas fa-save me-1"></i> Guardar Tostión
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Existing Toasts -->
                            @if($order->toasts->count())
                                <div class="mt-3">
                                    <span class="small fw-bold text-muted text-uppercase">
                                        <i class="fas fa-fire text-danger me-1"></i> Batches Registrados:
                                    </span>
                                    <div class="table-responsive mt-2">
                                        <table class="table table-sm table-bordered mb-0 bg-white">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Peso Inicial</th>
                                                    <th>Peso Final</th>
                                                    <th>Merma</th>
                                                    <th>% Pérdida</th>
                                                    <th>Fecha Registro</th>
                                                    <th class="text-end">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->toasts as $toast)
                                                    @php
                                                        $pct = (float)$toast->start_weight > 0 ? round(((float)$toast->decrease / (float)$toast->start_weight) * 100, 1) : 0;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $toast->start_weight }} kg</td>
                                                        <td>{{ $toast->final_weight }} kg</td>
                                                        <td class="text-danger fw-bold">-{{ $toast->decrease }} kg</td>
                                                        <td><span class="badge bg-warning text-dark">{{ $pct }}%</span></td>
                                                        <td>{{ $toast->created_at->format('d/m/Y H:i') }}</td>
                                                        <td class="text-end">
                                                            <form action="{{ route('toasts.destroy', $toast->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este registro de tostión?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-xs btn-outline-danger py-0 px-2" title="Eliminar">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Sección Pedidos Maquila -->
    <div class="section-card">
        <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--cafe-olive);">
            <span><i class="fas fa-industry me-2"></i> Pedidos de Maquila</span>
            <span class="badge bg-light text-dark">{{ $maquilaOrders->count() }}</span>
        </div>
        <div class="card-body p-3">
            @if($maquilaOrders->isEmpty())
                <p class="text-muted text-center py-3 mb-0">No hay órdenes de maquila registradas.</p>
            @else
                <div class="list-group">
                    @foreach($maquilaOrders as $order)
                        <div class="list-group-item p-3 mb-3 border rounded shadow-sm">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div>
                                    <div class="fw-bold fs-6">
                                        <span class="badge bg-info text-dark">Maquila #{{ $order->id }}</span>
                                        {{ $order->costumer->name ?? 'Cliente N/A' }} 
                                        @if($order->costumer && $order->costumer->farm)
                                            <span class="text-muted fw-normal">({{ $order->costumer->farm }})</span>
                                        @endif
                                    </div>
                                    <div class="small text-muted">
                                        <i class="fas fa-user-circle me-1"></i> Operario: {{ $order->user->name ?? 'N/A' }} • 
                                        <i class="fas fa-coffee me-1"></i> Tipo: {{ ucfirst($order->coffe_type) }} • 
                                        <i class="fas fa-fire me-1"></i> Tostión solicitada: {{ ucfirst($order->toast_type ?? 'N/A') }}
                                    </div>
                                </div>

                                <button class="btn btn-sm btn-olive"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#toastFormMaq{{ $order->id }}">
                                    <i class="fas fa-plus-circle me-1"></i> Añadir Tostión
                                </button>
                            </div>

                            <!-- Collapse Form -->
                            <div class="collapse mt-3" id="toastFormMaq{{ $order->id }}">
                                <form action="{{ route('toasts.store') }}" method="POST" class="p-3 bg-light rounded border">
                                    @csrf
                                    <input type="hidden" name="maquila_order_id" value="{{ $order->id }}">

                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Peso Inicial Verde (kg)</label>
                                            <input id="startW_maq_{{ $order->id }}" 
                                                   type="number" step="0.01" min="0" 
                                                   name="start_weight" class="form-control" 
                                                   oninput="calcMerma('startW_maq_{{ $order->id }}', 'finalW_maq_{{ $order->id }}', 'decrease_maq_{{ $order->id }}')" 
                                                   placeholder="Ej: 100.00" required>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Peso Final Tostado (kg)</label>
                                            <input id="finalW_maq_{{ $order->id }}" 
                                                   type="number" step="0.01" min="0" 
                                                   name="final_weight" class="form-control" 
                                                   oninput="calcMerma('startW_maq_{{ $order->id }}', 'finalW_maq_{{ $order->id }}', 'decrease_maq_{{ $order->id }}')" 
                                                   placeholder="Ej: 82.30" required>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Merma Calculada (kg)</label>
                                            <input id="decrease_maq_{{ $order->id }}" 
                                                   type="number" step="0.01" 
                                                   name="decrease" class="form-control bg-white" 
                                                   placeholder="0.00" readonly required>
                                        </div>
                                    </div>

                                    <div class="mt-3 text-end">
                                        <button type="submit" class="btn btn-sm btn-olive">
                                            <i class="fas fa-save me-1"></i> Guardar Tostión
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Existing Toasts -->
                            @if($order->toasts->count())
                                <div class="mt-3">
                                    <span class="small fw-bold text-muted text-uppercase">
                                        <i class="fas fa-fire text-danger me-1"></i> Batches Registrados:
                                    </span>
                                    <div class="table-responsive mt-2">
                                        <table class="table table-sm table-bordered mb-0 bg-white">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Peso Inicial</th>
                                                    <th>Peso Final</th>
                                                    <th>Merma</th>
                                                    <th>% Pérdida</th>
                                                    <th>Fecha Registro</th>
                                                    <th class="text-end">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->toasts as $toast)
                                                    @php
                                                        $pct = (float)$toast->start_weight > 0 ? round(((float)$toast->decrease / (float)$toast->start_weight) * 100, 1) : 0;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $toast->start_weight }} kg</td>
                                                        <td>{{ $toast->final_weight }} kg</td>
                                                        <td class="text-danger fw-bold">-{{ $toast->decrease }} kg</td>
                                                        <td><span class="badge bg-warning text-dark">{{ $pct }}%</span></td>
                                                        <td>{{ $toast->created_at->format('d/m/Y H:i') }}</td>
                                                        <td class="text-end">
                                                            <form action="{{ route('toasts.destroy', $toast->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este registro de tostión?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-xs btn-outline-danger py-0 px-2" title="Eliminar">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function calcMerma(startInputId, finalInputId, decreaseInputId) {
    const startVal = parseFloat(document.getElementById(startInputId).value) || 0;
    const finalVal = parseFloat(document.getElementById(finalInputId).value) || 0;
    const decreaseEl = document.getElementById(decreaseInputId);

    if (startVal > 0 && finalVal > 0) {
        const diff = startVal - finalVal;
        decreaseEl.value = (diff >= 0 ? diff : 0).toFixed(2);
    } else {
        decreaseEl.value = '';
    }
}
</script>

@include('footer')
