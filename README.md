# ☕ CAFÉ MOLINA — Sistema Integral de Gestión Cafetera, Maquila y Trazabilidad

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-8.75-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 8">
  <img src="https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8+">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap 5.3">
  <img src="https://img.shields.io/badge/MySQL-Supported-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/DomPDF-Enabled-556B2F?style=for-the-badge&logo=adobeacrobatreader&logoColor=white" alt="DomPDF">
  <img src="https://img.shields.io/badge/Licencia-MIT-green?style=for-the-badge" alt="MIT License">
</p>

---

## 📖 Visión General del Proyecto

**CAFÉ MOLINA** es una plataforma de software ERP y gestión operativa de manufactura diseñada a medida para plantas de beneficio, tostadurías de café especial y empresas de transformación agroindustrial cafetera.

El sistema resuelve la desconexión típica entre el ingreso del café pergamino seco (CPS) de los caficultores y el producto terminado empacado, proporcionando trazabilidad rigurosa por lote, control granulométrico por tamizado en mallas, monitoreo de curvas de tostión y control estricto de mermas, tablero de control de producción en planta, facturación/remisión en PDF y un cuadro de mando analítico en tiempo real.

El software contempla **dos líneas de negocio principales**:
1. **🏭 Servicios de Maquila**: Prestación de servicios técnicos de transformación de café a productores y fincas aliadas (trillado, selección por mallas, tostión según perfil solicitado, molienda y empaquetado con válvula desgasificadora y marquilla).
2. **☕ Línea Propia (Café Molina)**: Formulación, empaque y despacho de café especial bajo la marca comercial propia de la empresa, tanto en grano como molido, calculando automáticamente la materia prima verde requerida según las mermas de tostado.

---

## 🚀 Módulos y Capacidades del Sistema

### 1. 📋 Tablero de Producción (Orders Board / Kanban)
- **Monitoreo en 4 Estaciones de Planta**:
  - `1. Trillado & Mallas`: Recepción, trilla y tamizado granulométrico.
  - `2. Tostión`: Ingreso al tostador, curvas de calor y enfriamiento.
  - `3. Empaque & Molienda`: Molido según especificación, embolsado y sellado.
  - `4. Terminados`: Lotes listos para entrega o despacho al cliente.
- **Matriz de 11 Estados Operativos**:
  `AlmacenamientoInicial` ➔ `Trillado` ➔ `Monitoreo` ➔ `AlmacenamientoFinal` ➔ `Tostion` ➔ `Desgasificacion` ➔ `Filtrado` ➔ `Molido` ➔ `Empaquetado` ➔ `Almacenado` ➔ `Terminado`.
- **Actualización Interactiva**: Los operarios marcan el avance de cada estado con un clic en el tablero, actualizando el registro de forma asíncrona vía AJAX/Fetch con confirmación visual.
- **Priorización Inteligente**: Algoritmo de ordenamiento que prioriza pedidos con **Criterio Gerencial** y pedidos marcados como **Urgentes**.

### 2. 🏭 Módulo de Maquila de Café
- **Recepción Técnica**:
  - Calidades de café recibidas: `CPS`, `Honey`, `Natural`, `Excelso`, `Subproducto`.
  - Tipos: `Almendra` o `Tostado`.
  - Tostión solicitada: `Bajo` (claro), `Medio`, `Medio-Alto`, `Alto`.
  - Variables físicas: Kilogramos brutos recibidos, **Humedad Verde (%)** y **Densidad Verde ($g/cm^3$)**.
  - **Deducción de Tara Automática**: Descuento exacto según empaque de entrada (`Estopa: 0.15 kg/ud` o `Bulto: 0.70 kg/ud`) para fijar los **Kilos Netos** reales a procesar.
- **Tamizado Granulométrico (Mallas)**:
  - Registro de peso obtenido en cada tamiz: `Malla 18`, `Malla 17`, `Malla 15`, `Malla 14` y `Fondo`.
- **Servicios Adicionales**:
  - Selección de servicios requeridos: Trilla, Tostión, Molienda, Empaque, Despasillado, etc.
- **Empaquetado por Lote**:
  - Distribución del café resultante en presentaciones comerciales (`250g`, `340g`, `500g`, `1000g`, `2500g`), tipo de bolsa y malla de origen.

### 3. ☕ Módulo de Pedidos Propios (Café Molina)
- Creación ágil de órdenes de venta para café de la marca propia.
- Selección de productos del catálogo (ej. Café Supremo, Café Premium Arábica, Tostado Oscuro, Molido Fino, Descafeinado).
- Selección de tipo: `Grano` o `Molido`.
- Selección de gramaje/presentación y cantidad de unidades.
- **Cálculo de Materia Prima Requerida**: Deducción algorítmica de los kilos verdes necesarios para cubrir el pedido considerando las mermas proyectadas.

### 4. 🔥 Control de Tostiones & Registro de Mermas
- Registro por lote del **Peso Inicial Verde (kg)** y **Peso Final Tostado (kg)**.
- **Cálculo instantáneo de la Merma**: $\text{Merma} = \text{Peso Inicial} - \text{Peso Final}$ y porcentaje de pérdida de masa (% merma).
- Historial detallado de todas las tostiones efectuadas por orden, permitiendo auditorías de rendimiento del tostador.
- Opción de eliminar registros erróneos para mantener la integridad de los datos.

### 5. 👥 Directorio de Caficultores y Clientes
- Base de datos completa con nombre, Cédula / NIT, teléfono de contacto y finca / predio de procedencia.
- **Modal de Creación Rápida**: Posibilidad de registrar nuevos productores directamente desde el formulario de órdenes sin interrumpir la captura de datos.
- Vista de perfil individual con historial completo de órdenes de maquila y pedidos propios por productor.

### 6. 📊 Dashboard Analítico & Métricas en Tiempo Real
- **KPIs Principales**:
  - Kilos totales procesados (discriminados entre Maquila y Línea Café Molina).
  - Lotes activos en planta vs pedidos terminados.
  - Alerta de pedidos urgentes en cola.
  - Productor con mayor volumen histórico y producto más vendido.
- **Gráficos Interactivos (Chart.js)**:
  - Evolución mensual de pedidos por línea de negocio.
  - Gráfico de torta con la proporción entre Maquila y Marca Propia.
  - Estado del pipeline de producción (en proceso vs completados).

### 7. 📄 Generación de Reportes PDF Oficiales (DomPDF)
- Generación de remisiones técnicas en PDF listas para imprimir o enviar digitalmente:
  - **Orden de Maquila**: Ficha técnica completa de recepción, tara, kilos netos, mallas, servicios seleccionados, desglose de empaque, histórico de tostiones y firmas de entrega y recibo.
  - **Orden de Pedido Propio**: Desglose de productos, presentaciones, unidades, kilos equivalentes y firmas de despacho.

---

## 📐 Fórmulas y Lógica de Negocio

El sistema implementa las siguientes reglas de cálculo:

### 1. Cálculo de Kilos Netos en Recepción
$$\text{Kilos Netos} = \text{Kilos Recibidos} - (\text{Cantidad Empaques} \times \text{Tara})$$
- *Tara Estopa*: $0.150\text{ kg}$
- *Tara Bulto*: $0.700\text{ kg}$

### 2. Estimación de Café Verde para Pedidos Propios
Para compensar la merma durante el proceso de tostión y molienda:
- **Para Café en Grano**:
  $$\text{Peso Tostión} = \frac{(\text{Gramaje} \times \text{Cantidad}) / 1000}{0.82}$$
- **Para Café Molido**:
  $$\text{Peso Tostión} = \frac{(\text{Gramaje} \times \text{Cantidad}) / 1000}{0.785}$$

### 3. Estimación de Fecha de Entrega (Días de Producción)
Calcula automáticamente la fecha estimada de entrega (`departure_date`) considerando el peso del lote y los días acumulados por pedidos pendientes en planta:
$$\text{Días Calculados} = 1 + \left(1 + \frac{W}{525} + \frac{W}{225} + \frac{W}{500}\right) + \text{Días Cola}$$
Donde $W$ es el peso neto en kilogramos y $\text{Días Cola}$ representa la sumatoria de tiempos de los lotes aún no finalizados (`state_id != 11`).

---

## 🛠️ Stack Tecnológico

| Capa | Tecnología |
| :--- | :--- |
| **Framework Backend** | [Laravel 8.75](https://laravel.com/) (Arquitectura MVC, Eloquent ORM, Validaciones) |
| **Lenguaje** | PHP 7.4 / 8.0 / 8.1+ |
| **Base de Datos** | MySQL 5.7+ / MariaDB 10.3+ (Compatible con SQLite y PostgreSQL) |
| **Frontend / Plantillas** | Blade Templates, HTML5 Semántico, CSS3 |
| **Framework CSS / UI** | [Bootstrap 5.3](https://getbootstrap.com/) & FontAwesome 6 |
| **Gráficos & Métricas** | [Chart.js](https://www.chartjs.org/) |
| **Motor de Reportes PDF** | [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf) (DomPDF) |
| **Entorno Docker Opcional** | Laravel Sail / Docker Desktop |

---

## ⚙️ Guía de Instalación y Puesta en Marcha

### Requisitos Previos
- **PHP** $\ge$ 7.4 o 8.0+ con extensiones: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `gd`.
- **Composer** (Gestor de dependencias de PHP).
- **MySQL** o MariaDB (local, XAMPP, Laragon o Docker).
- **Git**.

---

### Paso 1: Clonar el Repositorio
```bash
git clone https://github.com/eidarragav/cafe_molina.git
cd cafe_molina
```

### Paso 2: Configurar las Variables de Entorno
Copia la plantilla de entorno `.env.example` a `.env`:
```bash
cp .env.example .env
```
*(En Windows PowerShell: `Copy-Item .env.example .env`)*

Abre el archivo `.env` y configura tus credenciales de base de datos MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cafe_molina
DB_USERNAME=root
DB_PASSWORD=
```
> **Nota**: Asegúrate de haber creado la base de datos `cafe_molina` en tu gestor MySQL (phpMyAdmin, DBeaver, HeidiSQL o CLI: `CREATE DATABASE cafe_molina;`).

### Paso 3: Instalar Dependencias de Composer
```bash
composer install
```

### Paso 4: Generar la Clave de Aplicación
```bash
php artisan key:generate
```

### Paso 5: Ejecutar Migraciones y Poblado de Datos (Seeders)
Ejecuta las migraciones junto con los seeders preconfigurados que cargan los 11 estados de planta, usuarios operarios, roles, catálogo de mallas, empaques, medidas, servicios y clientes iniciales:
```bash
php artisan migrate --seed
```

### Paso 6: Iniciar el Servidor de Desarrollo
```bash
php artisan serve
```
La aplicación estará disponible inmediatamente en: **`http://localhost:8000`**

---

## 🔑 Credenciales de Acceso Iniciales

El comando `migrate --seed` genera automáticamente las siguientes cuentas de usuario operarias listas para ingresar:

| Rol / Tipo | Correo Electrónico | Contraseña |
| :--- | :--- | :--- |
| **Administrador / Planta** | `admin@cafemolina.com` | `password123` |
| **Operario de Tostión** | `juan@cafemolina.com` | `password123` |
| **Operario de Calidad** | `maria@cafemolina.com` | `password123` |
| **Operario de Empaque** | `carlos@cafemolina.com` | `password123` |
| **Operario de Trilla** | `ana@cafemolina.com` | `password123` |

*(También puedes registrar nuevos usuarios directamente desde la pantalla de Registro o mediante el módulo interno de Gestión de Usuarios).*

---

## 📁 Estructura del Código

```
cafe_molina/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php      # KPIs, analítica y gráficos Chart.js
│   │   │   ├── OrderBoardController.php     # Tablero Kanban y agrupación de estados
│   │   │   ├── MaquilaOrderController.php   # Lógica completa de servicios de maquila
│   │   │   ├── OwnOrderController.php       # Gestión de pedidos propios Café Molina
│   │   │   ├── ToastController.php          # Registro de curvas de tostión y mermas
│   │   │   ├── CostumerController.php       # Directorio y CRUD de caficultores
│   │   │   ├── UserController.php           # Administración del equipo y operarios
│   │   │   └── HomeController.php           # Redirección de autenticación
│   ├── Models/
│   │   ├── MaquilaOrder.php                 # Modelo de orden de maquila
│   │   ├── OwnOrder.php                     # Modelo de orden propia
│   │   ├── Costumer.php                     # Modelo de cliente / productor
│   │   ├── Toast.php                        # Modelo de registro de tostión
│   │   ├── State.php                        # 11 Estados de producción
│   │   ├── Mesh.php                         # Mallas (tamices de clasificación)
│   │   ├── Package.php                      # Empaques y embalajes
│   │   └── Product.php                      # Catálogo de café propio
├── database/
│   ├── migrations/                          # Definición del esquema relacional
│   └── seeders/                             # Datos maestros y usuarios iniciales
├── resources/
│   ├── views/
│   │   ├── welcome.blade.php                # Landing page de bienvenida y flujo operativo
│   │   ├── navbar.blade.php                 # Barra superior unificada con alertas y sesión
│   │   ├── footer.blade.php                 # Pie de página responsive institucional
│   │   ├── dashboard/                       # Métricas, KPIs y gráficos Chart.js
│   │   ├── manage_orders/                   # Tablero Kanban por estaciones
│   │   ├── maquila_order/                   # Creación, edición, vista y PDF de maquilas
│   │   ├── own_order/                       # Creación, edición, vista y PDF propios
│   │   ├── tostiones/                       # Control de tostiones y mermas
│   │   ├── costumers/                       # Directorio y modales de clientes
│   │   ├── users/                           # Directorio y modales de usuarios
│   │   └── auth/                            # Vistas estilizadas de login y registro
└── routes/
    └── web.php                              # Enrutamiento protegido por middleware auth
```

---

## 🛡️ Mejoras de Calidad y Correcciones Implementadas

En la versión actual se corrigieron y robustecieron aspectos críticos del sistema:

1. **Corrección de Lógica de Estados en Controladores**:
   - Se corrigió la consulta de días pendientes en cola que buscaba erróneamente `where('id', 11)` en la tabla pivote en lugar de `where('state_id', 11)` (estado "Terminado"), lo que impedía calcular correctamente la fecha estimada de entrega.
2. **Eliminación del Problema de Consultas N+1**:
   - En el tablero de órdenes (`OrderBoardController`), se precargaron los estados y relaciones en una sola consulta para evitar consultas recurrentes a la base de datos por cada tarjeta desplegada.
3. **Corrección de Errores JavaScript y Duplicación de Eventos**:
   - Se eliminaron las definiciones duplicadas de funciones JavaScript que se generaban dentro de los bucles `@foreach` en las vistas de tostiones y tablero de órdenes, evitando peticiones PATCH redundantes al servidor.
   - Se eliminaron llamadas a funciones no definidas (`update_dpdate()`, `departure_date()`) que causaban errores `Uncaught ReferenceError` en la consola del navegador.
4. **Diseño de Plantillas PDF Profesionales (DomPDF)**:
   - Se rediseñaron por completo las plantillas de reporte PDF (`maquila_order/pdf/show.blade.php` y `own_order/pdf/show.blade.php`), retirando barras de navegación web y dependencias CDN externas que rompían el renderizado en DomPDF, logrando remisiones limpias, estéticas y con firmas de conformidad.
5. **Corrección de Clases CSS y Formularios**:
   - Se corrigió el desajuste de clases en la pantalla de inicio de sesión (`.cafe-card` por `.brand-card`), restaurando la estética y alineación de la interfaz.
   - Se corrigió el campo de fecha de salida en la edición de pedidos de maquila que mostraba por error la fecha de entrada.
   - Se equilibró la rejilla de columnas en el formulario de pedidos propios (anteriormente sumaba 14 columnas, causando desbordamientos visuales).
6. **Seguridad y Rutas**:
   - Todas las rutas operativas (`/dashboard`, `/orders-board`, `/own-orders`, `/maquila-orders`, `/tostiones`, `/costumers`, `/users`) fueron agrupadas bajo el middleware de autenticación `auth`, garantizando que ninguna pantalla falle por intentar acceder a `Auth::user()` siendo invitado y blindando los datos de la planta.
7. **Controlador y Vistas de Clientes y Usuarios**:
   - Se implementó el controlador faltante `UserController` y las vistas completas de clientes (`costumers.index`, `costumers.show`) y usuarios (`users.index`), permitiendo la administración total del personal y caficultores.

---

## ☕ Créditos & Licencia

Desarrollado para la optimización de procesos cafetaleros artesanales e industriales.
Distribuido bajo la licencia **[MIT](LICENSE)**.
