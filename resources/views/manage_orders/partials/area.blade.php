
@if(! isset($title) || ! isset($items))
    {{-- require $title and $items --}}
    @php return; @endphp
@endif

<div class="card shadow-sm col-12">
    <div class="card-header" style="background:#556B2F; color:white; font-weight:700;">
        {{ $title }}
    </div>
    <div class="card-body">
        @if(empty($items) || $items->isEmpty())
            <div class="text-muted">No hay pedidos en esta área.</div>
        @endif

        @foreach($items as $item)
            @php
                $type = data_get($item, 'type', 'own');
                $o = data_get($item, 'order');
            @endphp

            @unless($o)
                @continue
            @endunless

            <div class="card mb-3">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fw-bold">
                                @if($type === 'own')
                                    CM - {{ $o->costumer->name}}
                                @else
                                    MAQUILA - {{ $o->costumer->name }}
                                @endif
                            </div>

                            <div class="small text-muted">
                                Cliente: {{ optional($o->costumer)->name ?? '—' }} • Usuario: {{ optional($o->user)->name ?? '—' }}
                            </div>

                            <div class="small text-muted">
                                Fecha: {{ $o->entry_date ?? (optional($o->created_at)->format('Y-m-d') ?? '—') }}
                            </div>
                        </div>

                        <div class="text-end">
                            <span class="badge bg-secondary">{{ ucfirst($o->status ?? '—') }}</span>
                            <div class="mt-2">
                                @if($type === 'own')
                                    <a href="{{ route('own-orders.show', $o->id) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                @else
                                    <a href="{{ route('maquila.orders.show', $o->id) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                    <a href="{{ route('maquila.pdf', $o->id) }}" class="btn btn-sm btn-outline-primary">Descargar</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($type === 'own' && isset($o->own_order_product) && $o->own_order_product->isNotEmpty())
                        <hr class="my-2">
                        <div class="small">
                            Productos:
                            <ul class="mb-0">
                                @foreach($o->own_order_product as $p)
                                    <li>
                                        {{ optional($p->product)->name ?? '—' }} —
                                        {{ $p->quantity ?? '—' }}
                                        @if(optional($p->weight)->presentation)
                                            × {{ $p->weight->presentation }}
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @php
                        // use statement removed for Blade syntax compatibility
                        // Load all states once
                        $allStates = \App\Models\State::all();
                        // Get order states with selected info
                        $orderStates = null;
                        if ($type === 'own' && method_exists($o, 'own_order_states')) {
                            $orderStates = $o->own_order_states()->get() ?? collect();
                        } elseif ($type === 'maquila' && method_exists($o, 'maquila_order_states')) {
                            $orderStates = $o->maquila_order_states()->get() ?? collect();
                        }
                    @endphp

                    <hr/>

                    @php
                    $groups = [
                        'Trillado' => [1, 2, 3, 4],      
                        'Tostión' => [5, 6],
                        'Empaquetado' => [7, 8, 9, 10],
                        'Terminado' => [11],
                    ];
                    @endphp

                    @foreach($groups as $groupName => $ids)
                        <h6 class="mt-2 mb-1 fw-bold">{{ $groupName }}</h6>

                        <div class="d-flex gap-2 flex-wrap align-items-center states-checklist"
                            data-order-id="{{ $o->id }}"
                            data-order-type="{{ $type }}">

                            @foreach($allStates->whereIn('id', $ids) as $state)
                                @php
                                    $stateRelation = $orderStates ? $orderStates->firstWhere('state_id', $state->id) : null;
                                    $selected = $stateRelation && $stateRelation->selected === 'yes';
                                @endphp

                                <div class="state-checklist-item p-1 border rounded"
                                    style="cursor:pointer; user-select:none; {{ $selected ? 'background-color:#476e03; color:#fff;' : '' }}"
                                    data-state-id="{{ $state->id }}"
                                    data-selected="{{ $selected ? 1 : 0 }}">
                                    {{ $state->name }}
                                </div>
                            @endforeach

                        </div>
                    @endforeach


                    <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        document.querySelectorAll('.states-checklist').forEach(container => {
                            container.addEventListener('click', async (e) => {
                                const target = e.target;
                                if (!target.classList.contains('state-checklist-item')) return;

                                const orderId = container.getAttribute('data-order-id');
                                const orderType = container.getAttribute('data-order-type');
                                const stateId = target.getAttribute('data-state-id');
                                const currentlySelected = target.getAttribute('data-selected') === '1';

                                // Prevent multiple selections for now - only allow selecting "yes" once per state
                                if (currentlySelected) return;

                                container.style.pointerEvents = 'none';

                                try {
                                    const endpoint = orderType === 'own'
                                        ? `/own-orders/${orderId}/update-selected-state`
                                        : `/maquila-orders/${orderId}/update-selected-state`;

                                    const response = await fetch(endpoint, {
                                        method: 'PATCH',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': csrfToken,
                                        },
                                        body: JSON.stringify({ state_id: stateId, selected: 'yes' }),
                                    });

                                    if (!response.ok) {
                                        throw new Error('Network response was not OK');
                                    }

                                    target.style.backgroundColor = '#0d6efd';
                                    target.style.color = '#fff';
                                    target.setAttribute('data-selected', '1');

                                } catch (error) {
                                    alert('Error updating state selection: ' + error);
                                } finally {
                                    container.style.pointerEvents = '';
                                }
                            });
                        });
                    });
                    </script>

                    
                </div>
            </div>
        @endforeach
    </div>
</div>