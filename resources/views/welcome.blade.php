<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAFEMOLINA - Gestión de Pedidos y Productos</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* General Styles */
        :root {
            --primary-color: #5A3825;
            --secondary-color: #7a5237;
            --accent-color: #F8E7D3;
            --light-bg: #f5f1ed;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }

        /* Navbar */
        .navbar-cafe {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .navbar-cafe .nav-link {
            color: var(--accent-color) !important;
            font-weight: 500;
            margin: 0 8px;
            padding: 8px 12px !important;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .navbar-cafe .nav-link:hover {
            background-color: rgba(248, 231, 211, 0.2);
            color: #ffffff !important;
            transform: translateY(-2px);
        }

        .navbar-brand {
            color: var(--accent-color) !important;
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: var(--accent-color);
            padding: 100px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: rgba(248, 231, 211, 0.1);
            border-radius: 50%;
            z-index: 0;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 400px;
            height: 400px;
            background: rgba(248, 231, 211, 0.05);
            border-radius: 50%;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero-section p {
            font-size: 1.3rem;
            margin-bottom: 30px;
            opacity: 0.95;
        }

        .btn-hero {
            background-color: var(--accent-color);
            color: var(--primary-color);
            padding: 12px 30px;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            margin: 0 10px;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            color: var(--primary-color);
        }

        /* Features Section */
        .features-section {
            padding: 80px 20px;
            background-color: #ffffff;
        }

        .features-section h2 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 50px;
            text-align: center;
            font-size: 2.5rem;
        }

        .feature-card {
            background-color: var(--light-bg);
            border: 2px solid transparent;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .feature-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(90, 56, 37, 0.15);
        }

        .feature-card i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .feature-card h4 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #666;
            font-size: 0.95rem;
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: var(--accent-color);
            padding: 60px 20px;
        }

        .stat-box {
            text-align: center;
            padding: 30px;
        }

        .stat-box h3 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .stat-box p {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        /* Services Section */
        .services-section {
            padding: 80px 20px;
            background-color: var(--light-bg);
        }

        .services-section h2 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 50px;
            text-align: center;
            font-size: 2.5rem;
        }

        .service-item {
            background-color: #ffffff;
            padding: 25px;
            border-left: 4px solid var(--primary-color);
            border-radius: 6px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .service-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(90, 56, 37, 0.1);
        }

        .service-item h5 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .service-item p {
            color: #666;
            margin: 0;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: var(--accent-color);
            padding: 60px 20px;
            text-align: center;
        }

        .cta-section h2 {
            font-size: 2.3rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .cta-section p {
            font-size: 1.1rem;
            margin-bottom: 30px;
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: var(--accent-color);
            padding: 40px 20px 20px;
            margin-top: 0;
        }

        footer h5 {
            color: #ffffff;
            font-weight: 700;
            margin-bottom: 15px;
        }

        footer a {
            color: var(--accent-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: #ffffff;
        }

        footer hr {
            border-color: rgba(248, 231, 211, 0.2);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2rem;
            }

            .hero-section p {
                font-size: 1rem;
            }

            .features-section h2,
            .services-section h2 {
                font-size: 1.8rem;
            }

            .stat-box h3 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>

<!-- Navbar -->
@include('navbar')

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-content">
        <h1><i class="fas fa-coffee"></i> CAFEMOLINA</h1>
        <p>Sistema Integral de Gestión para tu Negocio de Café</p>
        <a href="{{ route('own-orders.index') }}" class="btn-hero">
            <i class="fas fa-rocket"></i> Comenzar Ahora
        </a>
        <a href="#features" class="btn-hero" style="background-color: transparent; border: 2px solid var(--accent-color); color: var(--accent-color);">
            <i class="fas fa-arrow-down"></i> Conocer Más
        </a>
    </div>
</section>

<!-- Features Section -->
<section class="features-section" id="features">
    <div class="container">
        <h2><i class="fas fa-star"></i> Nuestras Características</h2>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <i class="fas fa-cube"></i>
                    <h4>Gestión de Productos</h4>
                    <p>Administra tu catálogo de café con facilidad. Organiza productos, pesos y presentaciones.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <i class="fas fa-list-check"></i>
                    <h4>Pedidos Propios</h4>
                    <p>Crea y gestiona pedidos propios con múltiples productos en una sola interfaz intuitiva.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <i class="fas fa-cogs"></i>
                    <h4>Servicios de Maquila</h4>
                    <p>Ofrece servicios especializados de maquila a tus clientes de forma organizada.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <i class="fas fa-chart-line"></i>
                    <h4>Reportes y Análisis</h4>
                    <p>Obtén información detallada sobre tus pedidos y desempeño de negocio.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="stat-box">
                    <h3>500+</h3>
                    <p>Pedidos Procesados</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-box">
                    <h3>150+</h3>
                    <p>Clientes Satisfechos</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-box">
                    <h3>99%</h3>
                    <p>Tasa de Precisión</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-box">
                    <h3>24/7</h3>
                    <p>Disponibilidad</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section" id="services">
    <div class="container">
        <h2><i class="fas fa-briefcase"></i> Nuestros Servicios</h2>
        <div class="row">
            <div class="col-lg-6">
                <div class="service-item">
                    <h5><i class="fas fa-plus-circle"></i> Creación de Pedidos</h5>
                    <p>Crea fácilmente pedidos propios y de maquila con selección rápida de productos y cantidades.</p>
                </div>
                <div class="service-item">
                    <h5><i class="fas fa-users"></i> Gestión de Clientes</h5>
                    <p>Administra una base de datos completa de clientes con información de contacto y detalles de fincas.</p>
                </div>
                <div class="service-item">
                    <h5><i class="fas fa-fire"></i> Control de Tostiones</h5>
                    <p>Registra y controla el proceso de tostado con seguimiento detallado de cada lote.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="service-item">
                    <h5><i class="fas fa-weight"></i> Gestión de Pesos</h5>
                    <p>Define presentaciones personalizadas según tus necesidades de empaque y distribución.</p>
                </div>
                <div class="service-item">
                    <h5><i class="fas fa-clipboard-list"></i> Reportes Detallados</h5>
                    <p>Obtén reportes completos sobre pedidos, productos y desempeño de tu negocio.</p>
                </div>
                <div class="service-item">
                    <h5><i class="fas fa-shield-alt"></i> Seguridad y Confiabilidad</h5>
                    <p>Tus datos están protegidos con las mejores prácticas de seguridad del mercado.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section" id="contact">
    <div class="container">
        <h2>¿Listo para Gestionar tu Negocio de Café?</h2>
        <p>Únete a cientos de empresarios que confían en CAFEMOLINA</p>
        <a href="{{ route('own-orders.index') }}" class="btn-hero">
            <i class="fas fa-play-circle"></i> Empezar Ahora
        </a>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <h5><i class="fas fa-mug-hot"></i> CAFEMOLINA</h5>
                <p>La solución completa para la gestión de tu negocio de café. Aumenta tu productividad y eficiencia.</p>
            </div>
            <div class="col-md-4 mb-3">
                <h5>Enlaces Rápidos</h5>
                <ul class="list-unstyled">
                    <li><a href="#features">Características</a></li>
                    <li><a href="#services">Servicios</a></li>
                    <li><a href="{{ route('own-orders.index') }}">Panel de Control</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Contacto</h5>
                <p>
                    <i class="fas fa-phone"></i> +57 300 000 0000<br>
                    <i class="fas fa-envelope"></i> info@cafemolina.com<br>
                    <i class="fas fa-map-marker-alt"></i> Colombia
                </p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                <p>&copy; 2025 CAFEMOLINA. Todos los derechos reservados.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="#" class="me-3">Privacidad</a>
                <a href="#" class="me-3">Términos</a>
                <a href="#">Soporte</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>