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



<style>
    h2, h4, h5 {
        color: #556B2F;
        font-weight: 700;
    }

    .container {
        background-color: #FAFAF7; 
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 40px;
    }

    .card {
        border-radius: 12px;
        border: 1px solid #dfe4d4;
        background-color: #ffffff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }

    .card-header {
        background-color: #F7F9F4;
        font-weight: 600;
        font-size: 18px;
        border-bottom: 1px solid #dfe4d4;
        color: #556B2F;
    }

    table {
        background-color: #ffffff;
    }

    body {
        font-family: "DejaVu Sans", sans-serif;
        font-size: 14px;
    }

    h2 {
        font-weight: bold;
    }
</style>

<div class="container">

    <h2 class="mb-4">Detalles del Pedido de Maquila</h2>

    {{-- ================================
         INFORMACIÓN GENERAL
    ================================= --}}
    <div class="card">
        <div class="card-header">Información General</div>
        <div class="card-body">
            <p><strong>ID Pedido:</strong> {{ $order->id }}</p>
            <p><strong>Fecha:</strong> {{ $order->entry_date}}</p>
            <p><strong>Fecha de entrega:</strong> {{ $order->departure_date}}</p>
            <p><strong>Estado:</strong> {{ $order->status }}</p>

            <p><strong>Urgente:</strong> 
                @if($order->urgent_order === "yes")
                    <span class="badge bg-danger">Sí</span>
                @else
                    <span class="badge bg-secondary">No</span>
                @endif
            </p>
        </div>
    </div>


    {{-- ================================
         CLIENTE Y USUARIO
    ================================= --}}
    <div class="card">
        <div class="card-header">Cliente y Usuario</div>
        <div class="card-body">
            <p><strong>Cliente:</strong> {{ $order->costumer->name ?? 'N/A' }}</p>
            <p><strong>Usuario:</strong> {{ $order->user->name ?? 'N/A' }}</p>
        </div>
    </div>


    {{-- ================================
         DATOS TÉCNICOS
    ================================= --}}
    <div class="card">
        <div class="card-header">Datos Técnicos</div>
        <div class="card-body">
            <p><strong>Tipo de Café:</strong> {{ $order->coffe_type }}</p>
            <p><strong>Tipo de Calidad:</strong> {{ $order->quality_type }}</p>
            <p><strong>Tipo de Tostión:</strong> {{ $order->toast_type }}</p>
            <p><strong>Kilos Recibidos:</strong> {{ $order->recieved_kilograms }} kg</p>
            <p><strong>Kilos Netos:</strong> {{ $order->net_weight }} kg</p>

            <p><strong>Densidad Verde:</strong> {{ $order->green_density }}</p>
            <p><strong>Humedad Verde:</strong> {{ $order->green_humidity }}</p>
        </div>
    </div>


    {{-- ================================
         SERVICIOS DE MAQUILA
    ================================= --}}
    <div class="card">
        <div class="card-header">Servicios Seleccionados</div>
        <div class="card-body">
            @if($order->maquila_services->isEmpty())
                <p>No se seleccionaron servicios.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Selección</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->maquila_services as $maquila_service)
                        <tr>
                            <td>{{ $maquila_service->service->service_type ?? 'N/A' }}</td>
                            <td>{{ $maquila_service->selection }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>


    <div class="card">
        <div class="card-header">Mallas Seleccionadas</div>
        <div class="card-body">
            @if($order->maquila_meshes->isEmpty())
                <p>No se seleccionaron mallas.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Malla</th>
                            <th>Peso</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->maquila_meshes as $maquila_meshe)
                        <tr>
                            <td>{{ $maquila_meshe->mesh->meshe_type }}</td>
                            <td>{{ $maquila_meshe->weight }} kg</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>


    <div class="card">
        <div class="card-header">Empaques</div>
        <div class="card-body">
            @if($order->maquila_packages->isEmpty())
                <p>No hay empaques registrados.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Paquete</th>
                            <th>Malla</th>
                            <th>Kilos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->maquila_packages as $pkg)
                        <tr>
                            <td>{{ $pkg->package->package_type ?? 'N/A' }}</td>
                            <td>{{ $pkg->mesh }}</td>
                            <td>{{ $pkg->kilograms }} kg</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>


    <div class="card">
        <div class="card-header">Tostiones</div>
        <div class="card-body">
            @if($order->toasts->isEmpty())
                <p>No hay tostiones registradas.</p>
            @else
                <ul class="list-group">
                    @foreach($order->toasts as $toast)
                        <li class="list-group-item">
                            <strong>Peso inicial:</strong> {{ $toast->start_weight }} kg — 
                            <strong>Disminución:</strong> {{ $toast->decrease }} kg — 
                            <strong>Fecha:</strong> {{ $toast->created_at->format('Y-m-d H:i') }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>


    <div class="card">
        <div class="card-header">Observaciones</div>
        <div class="card-body">
            <p>{{ $order->observations ?: 'Sin observaciones.' }}</p>
        </div>
    </div>

</div>

