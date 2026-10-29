<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Cafe Molina') }} - Sistema de Gestión Cafetera</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        :root {
            --cafe-olive: #556B2F;
            --cafe-accent: #8DB600;
            --cafe-dark: #3b4d20;
            --cafe-brown: #6f4e37;
            --cafe-bg: #f4f6f8;
        }

        body {
            background: var(--cafe-bg);
            color: #2c3e50;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main, .page-wrapper {
            flex: 1 0 auto;
        }

        .card {
            border: none;
            border-radius: 14px;
            box-shadow: rgba(0,0,0,0.06) 0px 2px 8px;
            background: #ffffff;
        }

        .card h3 {
            font-weight: 600;
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: bold;
            color: var(--cafe-olive);
        }

        .chart-box {
            background: white;
            border-radius: 14px;
            box-shadow: rgba(0,0,0,0.06) 0px 2px 8px;
            padding: 20px;
        }

        .section-title {
            font-weight: 600;
            font-size: 20px;
            color: var(--cafe-olive);
        }

        .navbar-cafe {
            background-color: var(--cafe-olive);
            box-shadow: 0 2px 10px rgba(0,0,0,0.12);
            border-bottom: 3px solid var(--cafe-accent);
        }

        .navbar-cafe .nav-link {
            color: rgba(255, 255, 255, 0.92) !important;
            font-weight: 600;
            margin: 0 4px;
            padding: 8px 12px !important;
            border-radius: 6px;
            transition: all 0.25s ease;
        }

        .navbar-cafe .nav-link:hover {
            background-color: rgba(141, 182, 0, 0.25);
            color: #ffffff !important;
            transform: translateY(-1px);
        }

        .navbar-cafe .nav-link.active {
            background-color: var(--cafe-accent);
            color: white !important;
        }

        .navbar-brand {
            color: white !important;
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .navbar-brand i {
            margin-right: 8px;
            color: #F8E7D3;
        }

        .btn-olive {
            background-color: var(--cafe-olive);
            color: white;
            border: 1px solid var(--cafe-olive);
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.25s ease;
        }

        .btn-olive:hover, .btn-olive:focus {
            background-color: var(--cafe-accent);
            border-color: var(--cafe-accent);
            color: white;
        }

        .btn-cafe {
            background-color: var(--cafe-brown);
            color: white;
            font-weight: 600;
            border-radius: 8px;
        }

        .btn-cafe:hover {
            background-color: #553b2a;
            color: white;
        }

        .table-styled {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: rgba(0,0,0,0.06) 0px 2px 6px;
            border: none;
        }

        .table-styled thead {
            background: var(--cafe-olive);
            color: white;
            font-weight: 600;
            font-size: 15px;
        }

        .table-styled tbody tr {
            font-size: 14px;
            vertical-align: middle;
            transition: background 0.2s ease;
        }

        .table-styled tbody tr:hover {
            background: rgba(139,195,74,0.12);
        }

        .table-styled td, .table-styled th {
            padding: 12px 16px;
        }

        .section-card {
            border: none;
            border-radius: 14px;
            overflow: hidden;
            background: white;
            box-shadow: rgba(0,0,0,0.06) 0px 2px 6px;
            margin-bottom: 1.5rem;
        }

        .section-card .card-header {
            background: var(--cafe-olive);
            color: white;
            font-weight: 700;
            font-size: 17px;
            padding: 14px 18px;
            border: none;
        }

        .brand-section, .cafe-section {
            background-color: #ffffff;
            border-left: 5px solid var(--cafe-olive);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }

        .brand-card {
            border-left: 6px solid var(--cafe-olive);
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 8px 24px rgba(85, 107, 47, 0.15);
        }

        .brand-header {
            background-color: var(--cafe-olive);
            color: white;
            padding: 22px;
            border-radius: 12px 12px 0 0;
            font-weight: 700;
        }

        .brand-header i {
            color: #F8E7D3;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-cafe sticky-top">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ route('welcome') }}">
            <i class="fas fa-mug-hot"></i>CAFÉ MOLINA
        </a>
        <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
            <i class="fas fa-bars" style="color: #F8E7D3; font-size: 1.4rem;"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('manage.orders.*') ? 'active' : '' }}" href="{{ route('manage.orders.index') }}">
                            <i class="fas fa-tasks me-1"></i> Tablero de Órdenes
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('own-orders.*') ? 'active' : '' }}" href="{{ route('own-orders.index') }}">
                            <i class="fas fa-coffee me-1"></i> Café Molina
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('maquila-orders.*') ? 'active' : '' }}" href="{{ route('maquila-orders.index') }}">
                            <i class="fas fa-industry me-1"></i> Maquilas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tostiones.*') ? 'active' : '' }}" href="{{ route('tostiones.index') }}">
                            <i class="fas fa-fire me-1"></i> Tostiones
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('costumers.*') ? 'active' : '' }}" href="{{ route('costumers.index') }}">
                            <i class="fas fa-users me-1"></i> Clientes
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-chart-line me-1"></i> Métricas
                        </a>
                    </li>

                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle btn btn-sm px-3 py-1" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: rgba(255,255,255,0.15);">
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                            <li class="dropdown-header text-muted small">Sesión activa</li>
                            <li><span class="dropdown-item-text fw-bold">{{ Auth::user()->name }}</span></li>
                            <li><span class="dropdown-item-text small text-muted">{{ Auth::user()->email }}</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('users.index') }}">
                                    <i class="fas fa-user-shield me-2 text-muted"></i> Usuarios y Equipo
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesión
                        </a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i> Registrarse
                            </a>
                        </li>
                    @endif
                @endguest
            </ul>
        </div>
    </div>
</nav>

{{-- Flash Messages Container --}}
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> Por favor verifique los siguientes errores:
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>
