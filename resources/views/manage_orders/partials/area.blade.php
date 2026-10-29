@if(! isset($title) || ! isset($items))
    @php return; @endphp
@endif

@php
    $statesList = isset($allStates) ? $allStates : \App\Models\State::orderBy('id')->get();
    $groups = [
        'Trillado & Clasificación' => [1, 2, 3, 4],      
        'Tostión' => [5, 6],
        'Empaque & Molienda' => [7, 8, 9, 10],
        'Terminado' => [11],
    ];
@endphp

<div class="card shadow-sm col-12 h-100">
    <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--cafe-olive); color: white; font-weight: 700;">
        <span>{{ $title }}</span>
        <span class="badge bg-light text-dark rounded-pill">{{ $items->count() }}</span>
    </div>

    <div class="card-body p-2" style="background-color: #fafbfc; max-height: 820px; overflow-y: auto;">
        @if(empty($items) || $items->isEmpty())
            <div class="text-center py-4 text-muted small">
                <i class="fas fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                No hay pedidos en esta etapa.
            </div>
        @endif

        @foreach($items as $item)
            @php
                $type = data_get($item, 'type', 'own');
                $o = data_get($item, 'order');
            @endphp

            @unless($o)
                @continue
            @endunless

            <div class="card mb-3 border shadow-sm" style="border-radius: 10px;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="fw-bold d-flex align-items-center gap-1">
                                @if($type === 'own')
                                    <span class="badge" style="background-color: var(--cafe-brown);">Café Molina</span>
                                @else
                                    <span class="badge bg-info text-dark">Maquila</span>
                                @endif
                                <span class="text-dark">#{{ $o->id }}</span>
                            </div>

                            <div class="fw-semibold text-dark mt-1">
                                <i class="fas fa-user me-1 text-muted"></i> {{ optional($o->costumer)->name ?? 'Cliente N/A' }}
                            </div>

                            <div class="small text-muted">
                                <i class="fas fa-map-marker-alt me-1 text-muted"></i> {{ optional($o->costumer)->farm ?: 'Finca no registrada' }}
                            </div>
                        </div>

                        <div class="text-end">
                            @if($o->urgent_order === 'yes')
                                <span class="badge bg-danger mb-1 d-block"><i class="fas fa-exclamation-circle me-1"></i> Urgente</span>
                            @endif

                            @if($o->management_criteria === 'yes')
                                <span class="badge bg-warning text-dark mb-1 d-block"><i class="fas fa-star me-1"></i> Crit. Gerencial</span>
                            @endif

                            <div class="btn-group mt-1">
                                @if($type === 'own')
                                    <a href="{{ route('own-orders.show', $o->id) }}" class="btn btn-xs btn-outline-primary py-0 px-2" title="Ver Detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('own.pdf', $o->id) }}" class="btn btn-xs btn-outline-success py-0 px-2" title="Descargar PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <a href="{{ route('own-orders.edit', $o->id) }}" class="btn btn-xs btn-outline-warning py-0 px-2" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @else
                                    <a href="{{ route('maquila.orders.show', $o->id) }}" class="btn btn-xs btn-outline-primary py-0 px-2" title="Ver Detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('maquila.pdf', $o->id) }}" class="btn btn-xs btn-outline-success py-0 px-2" title="Descargar PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <a href="{{ route('maquila-orders.edit', $o->id) }}" class="btn btn-xs btn-outline-warning py-0 px-2" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row g-1 small text-muted my-2 p-2 rounded bg-light border">
                        <div class="col-6">
                            <strong>Entrada:</strong> {{ $o->entry_date ? \Carbon\Carbon::parse($o->entry_date)->format('d/m/Y') : '—' }}
                        </div>
                        <div class="col-6 text-end">
                            <strong>Entrega est.:</strong> {{ $o->departure_date ? \Carbon\Carbon::parse($o->departure_date)->format('d/m/Y') : 'Calculando' }}
                        </div>

                        @if($type === 'maquila')
                            <div class="col-6">
                                <strong>Kilos Netos:</strong> {{ $o->net_weight ?? $o->recieved_kilograms }} kg
                            </div>
                            <div class="col-6 text-end">
                                <strong>Tostión:</strong> {{ ucfirst($o->toast_type ?? 'N/A') }}
                            </div>
                        @endif
                    </div>

                    @if($type === 'own' && isset($o->own_order_product) && $o->own_order_product->isNotEmpty())
                        <div class="small mb-2">
                            <span class="fw-bold text-muted">Productos:</span>
                            <ul class="mb-0 ps-3">
                                @foreach($o->own_order_product as $p)
                                    <li>
                                        {{ optional($p->product)->name ?? 'Producto' }} — 
                                        <strong>{{ $p->quantity }}</strong>
                                        @if(optional($p->weight)->presentation)
                                            ({{ $p->weight->presentation }})
                                        @endif
                                        <span class="badge bg-light text-dark border">{{ $p->type }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @php
                        $orderStates = $type === 'own' ? $o->own_order_states : $o->maquila_order_states;
                    @endphp

                    <hr class="my-2"/>

                    <!-- Checklist of Stages -->
                    @foreach($groups as $groupName => $ids)
                        <div class="small fw-bold text-muted mt-2 mb-1" style="font-size: 11px; text-transform: uppercase;">
                            {{ $groupName }}
                        </div>

                        <div class="d-flex gap-1 flex-wrap align-items-center states-checklist mb-2"
                             data-order-id="{{ $o->id }}"
                             data-order-type="{{ $type }}">

                            @foreach($statesList->whereIn('id', $ids) as $state)
                                @php
                                    $stateRelation = $orderStates ? $orderStates->firstWhere('state_id', $state->id) : null;
                                    $selected = $stateRelation && $stateRelation->selected === 'yes';
                                @endphp

                                <div class="state-checklist-item px-2 py-1 rounded small"
                                     style="cursor:pointer; font-size: 11px; user-select:none; border: 1px solid {{ $selected ? 'var(--cafe-olive)' : '#ced4da' }}; {{ $selected ? 'background-color: var(--cafe-olive); color:#fff; font-weight:600;' : 'background-color:#ffffff; color:#495057;' }}"
                                     data-state-id="{{ $state->id }}"
                                     data-selected="{{ $selected ? 1 : 0 }}"
                                     title="{{ $selected ? 'Estado completado' : 'Clic para marcar como completado' }}">
                                    @if($selected)
                                        <i class="fas fa-check-circle me-1"></i>
                                    @else
                                        <i class="far fa-circle me-1 opacity-50"></i>
                                    @endif
                                    {{ $state->name }}
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                </div>
            </div>
        @endforeach
    </div>
</div>
