@include('navbar')

<div class="container my-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center" style="background:var(--cafe-primary); color:var(--cafe-accent);">
            <div>
                <strong>Pedido Propio #{{ $ownOrder->id }}</strong>
                <div class="small">Cliente: {{ optional($ownOrder->costumer)->name ?? '—' }} • Usuario: {{ optional($ownOrder->user)->name ?? '—' }}</div>
            </div>
            <div class="text-end">
                <div class="small">Estado: <span class="badge bg-secondary">{{ ucfirst($ownOrder->status ?? '—') }}</span></div>
                <p><strong>Fecha:</strong> {{ $ownOrder->entry_date}}</p>
                <p><strong>Fecha de entrega:</strong> {{ $ownOrder->departure_date}}</p>
                <p><strong>Kilos a tostar:</strong> {{ $sumW}}kg</p>
            </div>
        </div>

        <div class="card-body">
            <h5 class="mb-3">Detalles</h5>
            <dl class="row">
                <dt class="col-sm-3">Observaciones</dt>
                <dd class="col-sm-9">{{ $ownOrder->observations ?? '—' }}</dd>

                <dt class="col-sm-3">Urgente</dt>
                <dd class="col-sm-9">{{ $ownOrder->urgent_order === 'yes' ? 'Sí' : 'No' }}</dd>
            </dl>
            
            <hr>

            <h6>Productos</h6>
            @if($ownOrder->own_order_product && $ownOrder->own_order_product->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead style="background-color:var(--cafe-primary); color:var(--cafe-accent);">
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Peso/Presentación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ownOrder->own_order_product as $p)
                                <tr>
                                    <td>{{ optional($p->product)->name ?? '—' }}</td>
                                    <td>{{ $p->quantity ?? '—' }}</td>
                                    <td>{{ optional($p->weight)->presentation ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">No hay productos en este pedido.</div>
            @endif

            <hr>

            @if(isset($ownOrder->ownOrderStates) && $ownOrder->ownOrderStates->isNotEmpty())
                <h6>Estados (seguimiento)</h6>
                <div class="mb-3">
                    @foreach($ownOrder->ownOrderStates as $s)
                        <span class="badge me-1 {{ $s->selected === 'yes' ? 'bg-success' : 'bg-light text-dark' }}">
                            {{ optional($s->state)->name ?? ('Estado ' . $s->state_id) }}
                        </span>
                    @endforeach
                </div>
            @endif

            <div class="mt-3">
                <a href="{{ route('own-orders.index') }}" class="btn btn-secondary">Volver</a>
                <a href="#" class="btn btn-cafe">Editar</a>
            </div>
        </div>
    </div>
</div>

@include('footer')
</body>
</html>