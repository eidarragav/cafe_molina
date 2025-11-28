<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafemolina - Gestión</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* New brand style: natural, minimalistic, eco, artisanal */
        /* Olive green + white palette */

        .navbar-cafe {
            background-color: #556B2F; /* Olive Drab green */
            box-shadow: none;
            border-bottom: 2px solid #8DB600; /* lighter olive accent */
        }

        .navbar-cafe .nav-link {
            color: white !important;
            font-weight: 600;
            margin: 0 8px;
            padding: 8px 12px !important;
            border-radius: 4px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            position: relative;
        }

        .navbar-cafe .nav-link:hover {
            background-color: rgba(139, 195, 74, 0.2); /* light olive green transparent */
            color: #f0f0f0 !important;
            transform: translateY(-1px);
        }

        .navbar-cafe .nav-link.active {
            background-color: #8DB600;
            border-bottom: 3px solid white;
            color: white !important;
        }

        .navbar-brand {
            color: white !important;
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 2px;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            text-shadow: none;
            text-transform: uppercase;
            padding-left: 6px;
        }

        .navbar-brand i {
            margin-right: 8px;
            color: #A9BA9D; /* lighter olive hue for icon */
        }

        /* Button toggle - hamburger icon */
        .navbar-toggler border-0 {
            border: none !important;
        }

        .navbar-toggler .fas.fa-bars {
            color: white;
            font-size: 1.5rem;
        }

        /* Remove old cafe styles */
        .cafe-section, .btn-cafe, .table-cafe {
            /* not changed here as per instructions */
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .navbar-cafe .nav-link {
                margin: 4px 0;
                padding: 10px 0 !important;
            }

            .navbar-brand {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>


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

        
        </div>
    </div>
</div>

</body>
</html>