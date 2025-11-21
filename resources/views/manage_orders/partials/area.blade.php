
@if(! isset($title) || ! isset($items))
    {{-- require $title and $items --}}
    @php return; @endphp
@endif

<div class="card shadow-sm">
    <div class="card-header" style="background:var(--cafe-primary); color:var(--cafe-accent); font-weight:700;">
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
                                    Pedido Propio #{{ $o->id }}
                                @else
                                    Pedido Maquila #{{ $o->id }}
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
                                    <a href="{{ route('maquila-orders.show', $o->id) }}" class="btn btn-sm btn-outline-primary">Ver</a>
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

                    @if($type === 'maquila' && isset($o->maquila_meshes) && $o->maquila_meshes->isNotEmpty())
                        <hr class="my-2">
                        <div class="small">
                            Mallas (kg):
                            <ul class="mb-0">
                                @foreach($o->maquila_meshes as $m)
                                    <li>{{ optional($m->meshe)->meshe_type ?? ($m->meshe_type ?? '—') }}: {{ $m->weight ?? '0' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>