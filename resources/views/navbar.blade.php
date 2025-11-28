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
        /* New brand style: natural, minimalistic, eco, artisanal */
        /* Olive green + white palette */
        body {
            background: #f4f6f8;
            
        }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: rgba(0,0,0,0.06) 0px 2px 6px;
        }
        .card h3 {
            font-weight: 600;
        }
        .stat-number {
            font-size: 2.2rem;
            font-weight: bold;
        }
        .chart-box {
            height: 280px;
            background: white;
            border-radius: 16px;
            box-shadow: rgba(0,0,0,0.06) 0px 2px 6px;
            padding: 20px;
        }
        .section-title {
            font-weight: 600;
            font-size: 22px;
        }
        

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
                            <i class="fas fa-plus-circle"></i> CafeMolina
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('maquila-orders.index') }}">
                            <i class="fas fa-cogs"></i> Maquilas
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
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="{{ route('dashboard') }}">
                            <i class="fas fa-chart-line"></i> Dashboard
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

