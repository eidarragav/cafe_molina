@include('navbar')

<div class="container my-4">
    <div class="brand-section">
        <h3 class="mb-3 fw-bold" style="color: var(--cafe-olive);">
            <i class="fas fa-edit me-2"></i> Editar Pedido Café Molina #{{ $ownOrder->id }}
        </h3>

        <form id="ownOrderForm" action="{{ route('own-orders.update', $ownOrder->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold" for="user_id">Operario Responsable</label>
                    <select id="user_id" name="user_id" class="form-select" required>
                        <option value="{{ Auth::user()->id }}" selected>{{ Auth::user()->name }}</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold" for="costumer_id">Cliente / Destinatario</label>
                    <select id="costumer_id" name="costumer_id" class="form-select" required>
                        @foreach($costumers as $c)
                            <option value="{{ $c->id }}" {{ old('costumer_id', $ownOrder->costumer_id) == $c->id ? 'selected' : '' }}>
                                {{ $c->name }} — {{ $c->farm ?: 'Finca N/A' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold" for="entry_date">Fecha de Entrada</label>
                    <input id="entry_date" name="entry_date" type="date" class="form-control" required 
                           value="{{ old('entry_date', $ownOrder->entry_date ? \Carbon\Carbon::parse($ownOrder->entry_date)->format('Y-m-d') : '') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold" for="departure_date">Fecha Estimada de Salida</label>
                    <input id="departure_date" name="departure_date" type="date" class="form-control" 
                           value="{{ old('departure_date', $ownOrder->departure_date ? \Carbon\Carbon::parse($ownOrder->departure_date)->format('Y-m-d') : '') }}">
                    <div class="form-text">Si se deja vacía, se recalculará según la carga de trabajo.</div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold" for="urgent_select">¿Pedido Urgente?</label>
                    <select id="urgent_select" name="urgent_order" class="form-select" required>
                        <option value="no" {{ old('urgent_order', $ownOrder->urgent_order) == 'no' ? 'selected' : '' }}>No</option>
                        <option value="yes" {{ old('urgent_order', $ownOrder->urgent_order) == 'yes' ? 'selected' : '' }}>Sí</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold" for="management_criteria">Criterio Gerencial</label>
                    <select id="management_criteria" name="management_criteria" class="form-select" required>
                        <option value="no" {{ old('management_criteria', $ownOrder->management_criteria) == 'no' ? 'selected' : '' }}>No</option>
                        <option value="yes" {{ old('management_criteria', $ownOrder->management_criteria) == 'yes' ? 'selected' : '' }}>Sí</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-olive">
                    <i class="fas fa-save me-1"></i> Actualizar Pedido
                </button>
                <a href="{{ route('manage.orders.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

@include('footer')
