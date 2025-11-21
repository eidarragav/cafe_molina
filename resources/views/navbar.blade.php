<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafemolina - Gestión</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Colores estilo cafetera */
        .navbar-cafe {
            background: linear-gradient(135deg, #5A3825 0%, #7a5237 100%);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .navbar-cafe .nav-link {
            color: #F8E7D3 !important;
            font-weight: 500;
            margin: 0 8px;
            padding: 8px 12px !important;
            border-radius: 6px;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-cafe .nav-link:hover {
            background-color: rgba(248, 231, 211, 0.2);
            color: #ffffff !important;
            transform: translateY(-2px);
        }

        .navbar-cafe .nav-link.active {
            background-color: rgba(248, 231, 211, 0.3);
            border-bottom: 3px solid #F8E7D3;
        }

        .navbar-brand {
            color: #F8E7D3 !important;
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand i {
            margin-right: 8px;
        }

        /* Form & Table Styles */
        .cafe-section {
            background-color: #f5f1ed;
            border-left: 4px solid #5A3825;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .cafe-section h3 {
            color: #5A3825;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-label {
            color: #5A3825;
            font-weight: 600;
        }

        .btn-cafe {
            background-color: #5A3825;
            border-color: #5A3825;
            color: #F8E7D3;
            transition: all 0.3s ease;
        }

        .btn-cafe:hover {
            background-color: #7a5237;
            border-color: #7a5237;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(90, 56, 37, 0.3);
        }

        .table-cafe thead {
            background-color: #5A3825;
            color: #F8E7D3;
        }

        .table-cafe tbody tr:hover {
            background-color: #f0e6d2;
        }

        .btn-action {
            margin: 2px;
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

<nav class="navbar navbar-expand-lg navbar-cafe sticky-top">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ route('welcome') }}">
            <i class="fas fa-mug-hot"></i>CAFEMOLINA
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
            <i class="fas fa-bars" style="color: #F8E7D3; font-size: 1.5rem;"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('own-orders.index') }}">
                            <i class="fas fa-plus-circle"></i> Crear Pedido Propio
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('maquila-orders.index') }}">
                            <i class="fas fa-cogs"></i> Crear Pedido Maquila
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/tostiones">
                            <i class="fas fa-fire"></i> Tostiones
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="{{ route('manage.orders.index') }}">
                            <i class="fas fa-list"></i> Gestión de Pedidos
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> {{ Auth::user()->name ?? 'Perfil' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Configuración</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Mi Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                        </a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i> Registrarse
                            </a>
                        </li>
                    @endif
                @endguest
            </ul>
        </div>
    </div>
</nav>

