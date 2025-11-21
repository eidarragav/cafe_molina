<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Gestión de Pedidos - CAFEMOLINA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --cafe-primary: #5A3825;
            --cafe-accent: #F8E7D3;
            --cafe-light: #f5f1ed;
        }
        body { background: #faf8f6; }
        .navbar-cafe { background: linear-gradient(135deg, var(--cafe-primary), #7a5237); }
        .card-cafe { border-left: 4px solid var(--cafe-primary); background: #fff; }
        .badge-status { font-weight:600; }
        .filter-btn.active { box-shadow: 0 4px 12px rgba(90,56,37,0.12); transform: translateY(-2px); }
        .small-muted { color:#6c6c6c; font-size:.9rem; }
    </style>
</head>
<body>

@include('navbar')

<div class="container my-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0" style="color:var(--cafe-primary)">Gestión de Pedidos</h3>

        <div class="btn-group" role="group" aria-label="Filtros">
            <button class="btn btn-outline-secondary filter-btn active" data-filter="all">Todos</button>
            <button class="btn btn-outline-secondary filter-btn" data-filter="in_progress">En Proceso</button>
            <button class="btn btn-outline-secondary filter-btn" data-filter="finished">Finalizados</button>
        </div>
    </div>

    <div class="row g-3">

        <!-- OWN ORDERS -->
        @if(isset($ownOrders))
            @foreach($ownOrders as $order)
            <div class="col-md-6 order-card" data-status="{{ $order->status }}" data-type="own">
                <div class="card card-cafe shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title mb-1">Pedido Propio #{{ $order->id }}</h5>
                                <div class="small-muted">
                                    Cliente: {{ optional($order->costumer)->name ?? '—' }} · Usuario: {{ optional($order->user)->name ?? '—' }}
                                </div>
                                <div class="small-muted">Fecha: {{ $order->entry_date }}</div>
                            </div>

                            <div class="text-end">
                                <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'in_progress' ? 'warning' : 'secondary') }} badge-status">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex gap-2">
                            <!-- Status edit form -->
                            <form class="status-form d-flex gap-2 align-items-center" data-update-url="{{ route('own-orders.update', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <label class="mb-0 small-muted">Cambiar estado:</label>
                                <select name="status" class="form-select form-select-sm status-select" style="width:150px;">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="in_progress" {{ $order->status === 'in_progress' ? 'selected' : '' }}>En Proceso</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completado</option>
                                </select>
                                <button class="btn btn-sm btn-outline-primary save-status" type="button">Guardar</button>
                            </form>

                            <div class="ms-auto">
                                <button class="btn btn-sm btn-info view-details" type="button"
                                        data-bs-toggle="modal" data-bs-target="#orderDetailModal"
                                        data-type="own"
                                        data-order='@json($order->loadMissing(["ownOrderProducts.product","user","costumer"]))'>
                                    Ver
                                </button>
                                <a href="{{ route('own-orders.edit', $order->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('own-orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Eliminar pedido?')">Eliminar</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        @endif

        <!-- MAQUILA ORDERS -->
        @if(isset($maquilaOrders))
            @foreach($maquilaOrders as $m)
            <div class="col-md-6 order-card" data-status="{{ $m->status }}" data-type="maquila">
                <div class="card card-cafe shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title mb-1">Pedido Maquila #{{ $m->id }}</h5>
                                <div class="small-muted">
                                    Cliente: {{ optional($m->costumer)->name ?? '—' }} · Usuario: {{ optional($m->user)->name ?? '—' }}
                                </div>
                                <div class="small-muted">Creado: {{ $m->created_at ? $m->created_at->format('Y-m-d') : '—' }}</div>
                            </div>

                            <div class="text-end">
                                <span class="badge bg-{{ $m->status === 'completed' ? 'success' : ($m->status === 'in_progress' ? 'warning' : 'secondary') }} badge-status">
                                    {{ ucfirst($m->status) }}
                                </span>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex gap-2">
                            <form class="status-form d-flex gap-2 align-items-center" data-update-url="{{ route('maquila-orders.update', $m->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <label class="mb-0 small-muted">Cambiar estado:</label>
                                <select name="status" class="form-select form-select-sm status-select" style="width:150px;">
                                    <option value="pending" {{ $m->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="in_progress" {{ $m->status === 'in_progress' ? 'selected' : '' }}>En Proceso</option>
                                    <option value="completed" {{ $m->status === 'completed' ? 'selected' : '' }}>Completado</option>
                                </select>
                                <button class="btn btn-sm btn-outline-primary save-status" type="button">Guardar</button>
                            </form>

                            <div class="ms-auto">
                                <button class="btn btn-sm btn-info view-details" type="button"
                                        data-bs-toggle="modal" data-bs-target="#orderDetailModal"
                                        data-type="maquila"
                                        data-order='@json($m->loadMissing(["maquila_services","maquila_meshes","maquila_packages","user","costumer"]))'>
                                    Ver
                                </button>
                                <a href="{{ route('maquila-orders.edit', $m->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('maquila-orders.destroy', $m->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Eliminar pedido?')">Eliminar</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        @endif

    </div> 

</div> 

<!-- Detail Modal -->
<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background:var(--cafe-primary); color:var(--cafe-accent)">
                <h5 class="modal-title">Detalle del Pedido</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="detailContent">Cargando...</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Filter buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.filter-btn').forEach(b=>b.classList.remove('active'));
                btn.classList.add('active');
                const filter = btn.getAttribute('data-filter');
                document.querySelectorAll('.order-card').forEach(card => {
                    const status = card.getAttribute('data-status') || '';
                    if (filter === 'all') { card.style.display = ''; return; }
                    if (filter === 'in_progress') {
                        card.style.display = status === 'in_progress' ? '' : 'none';
                        return;
                    }
                    if (filter === 'finished') {
                        card.style.display = status === 'completed' ? '' : 'none';
                        return;
                    }
                });
            });
        });

        // Open detail modal and render content
        document.querySelectorAll('.view-details').forEach(btn => {
            btn.addEventListener('click', () => {
                const type = btn.getAttribute('data-type');
                let order = {};
                try { order = JSON.parse(btn.getAttribute('data-order')); } catch(e){ order = {}; }
                const container = document.getElementById('detailContent');
                container.innerHTML = renderOrderDetail(type, order);
            });
        });

        // Render order detail simple template
        function renderOrderDetail(type, o) {
            let html = `<h6 class="mb-2">#${o.id} — ${type === 'own' ? 'Pedido Propio' : 'Pedido Maquila'}</h6>`;
            html += `<p class="small-muted">Cliente: ${o.costumer?.name ?? '—'} · Usuario: ${o.user?.name ?? '—'}</p>`;
            if (type === 'own') {
                html += `<h6 class="mt-3">Productos</h6>`;
                if ((o.own_order_products || []).length === 0) {
                    html += `<p class="small-muted">No hay productos registrados.</p>`;
                } else {
                    html += `<ul class="list-group">`;
                    o.own_order_products.forEach(p => {
                        html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>${p.product?.name ?? ('#'+p.product_id)}</strong><br>
                                        <small class="small-muted">Peso: ${p.weight_id ?? '-'} · Cant: ${p.quantity}</small>
                                    </div>
                                </li>`;
                    });
                    html += `</ul>`;
                }
            } else {
                html += `<h6 class="mt-3">Servicios</h6>`;
                if ((o.maquila_services || []).length) {
                    html += `<ul class="list-group mb-2">`;
                    o.maquila_services.forEach(s => {
                        html += `<li class="list-group-item">${s.service_type ?? ('#'+(s.service_id||'—'))}</li>`;
                    });
                    html += `</ul>`;
                } else html += `<p class="small-muted">No hay servicios registrados.</p>`;

                html += `<h6 class="mt-3">Mallas</h6>`;
                if ((o.maquila_meshes || []).length) {
                    html += `<ul class="list-group mb-2">`;
                    o.maquila_meshes.forEach(m => {
                        html += `<li class="list-group-item">${m.weight ?? ('#'+(m.meshe_id||'—'))}</li>`;
                    });
                    html += `</ul>`;
                } else html += `<p class="small-muted">No hay mallas registradas.</p>`;

                html += `<h6 class="mt-3">Paquetes</h6>`;
                if ((o.maquila_packages || []).length) {
                    html += `<ul class="list-group">`;
                    o.maquila_packages.forEach(p => {
                        html += `<li class="list-group-item">Medida: ${p.measure_id ?? p.measure_type ?? '—'} · Kg: ${p.kilograms ?? '—'}</li>`;
                    });
                    html += `</ul>`;
                } else html += `<p class="small-muted">No hay paquetes registrados.</p>`;
            }

            return html;
        }

        // Save status via AJAX (fetch). Forms use data-update-url attr.
        document.querySelectorAll('.save-status').forEach(btn => {
            btn.addEventListener('click', async (e) => {
                const form = btn.closest('.status-form');
                const select = form.querySelector('.status-select');
                const url = form.getAttribute('data-update-url');
                const payload = new FormData();
                payload.append('_method', 'PUT');
                payload.append('status', select.value);
                payload.append('_token', csrf);

                btn.disabled = true;
                btn.textContent = 'Guardando...';
                try {
                    const res = await fetch(url, { method: 'POST', body: payload, headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    if (!res.ok) throw new Error('Error en la respuesta');
                    const json = await res.json().catch(()=>null);
                    // Update badge and card data-status (best-effort)
                    const card = btn.closest('.order-card');
                    if (card) {
                        card.setAttribute('data-status', select.value);
                        const badge = card.querySelector('.badge-status');
                        if (badge) {
                            badge.textContent = select.value.charAt(0).toUpperCase() + select.value.slice(1);
                            badge.classList.remove('bg-secondary','bg-warning','bg-success');
                            if (select.value === 'completed') badge.classList.add('bg-success');
                            else if (select.value === 'in_progress') badge.classList.add('bg-warning');
                            else badge.classList.add('bg-secondary');
                        }
                    }
                } catch (err) {
                    alert('No se pudo actualizar el estado. Compruebe la conexión o la ruta en el servidor.');
                } finally {
                    btn.disabled = false;
                    btn.textContent = 'Guardar';
                }
            });
        });

    })();
</script>

</body>
</html>