<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Pedido Maquila - CAFEMOLINA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .navbar-cafe { background-color: #5A3825; }
        .navbar-cafe .nav-link { color: #F8E7D3; }
        .navbar-brand { color: #F8E7D3 !important; }
        .cafe-section { background-color: #f5f1ed; border-left: 4px solid #5A3825; padding: 20px; margin-bottom: 30px; border-radius: 6px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);}
        .cafe-section h3 { color: #5A3825; font-weight: bold; margin-bottom: 20px; }
        .form-label { color: #5A3825; font-weight: 600; }
        .btn-cafe { background-color: #5A3825; border-color: #5A3825; color: #F8E7D3; }
        .btn-cafe:hover { background-color: #7a5237; border-color: #7a5237; color: #ffffff; }
        .table-cafe thead { background-color: #5A3825; color: #F8E7D3; }
        .section-card { background-color: #ffffff; border-left: 4px solid #5A3825; padding: 20px; margin-bottom: 20px; border-radius: 6px; }
        .section-card h5 { color: #5A3825; font-weight: 700; margin-bottom: 15px; }
        .btn-add { background-color: #5A3825; color: #F8E7D3; border: none; }
        .btn-add:hover { background-color: #7a5237; color: #ffffff; }
    </style>
</head>
<body>

@include('navbar')

<div class="container mt-4">

    <div class="cafe-section">
        <h3><i class="fas fa-cogs"></i> Crear Pedido Maquila</h3>


        <form id="maquilaOrderForm" action="{{route("maquila-orders.store")}}" method="POST">
            @csrf

            <!-- Main Order Info -->
            <div class="section-card">
                <h5><i class="fas fa-info-circle"></i> Información Principal</h5>
                
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label" for="user_id">Usuario</label>
                        <select id="user_id" name="user_id" class="form-select" required>
                            <option value="">-- Seleccione usuario --</option>
                                 @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                 @endforeach
                            
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="costumer_id">Cliente</label>
                        <select id="costumer_id" name="costumer_id" class="form-select" required>
                            <option value="">-- Seleccione cliente --</option>
                                 @foreach($costumers as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                 @endforeach

                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="coffe_type">Tipo de Café</label>
                        <input id="coffe_type" name="coffe_type" type="text" class="form-control" placeholder="Ej: Arábica, Robusta" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label" for="quality_type">Tipo de Calidad</label>
                        <select id="quality_type" name="quality_type" class="form-select" required>
                            <option value="">-- Seleccione calidad --</option>
                            <option value="premium">Premium</option>
                            <option value="superior">Superior</option>
                            <option value="estándar">Estándar</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="toast_type">Tipo de Tostado</label>
                        <select id="toast_type" name="toast_type" class="form-select" required>
                            <option value="">-- Seleccione tostado --</option>
                            <option value="claro">Claro</option>
                            <option value="medio">Medio</option>
                            <option value="oscuro">Oscuro</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="recieved_kilograms">Kilogramos Recibidos</label>
                        <input id="recieved_kilograms" name="recieved_kilograms" type="number" step="0.01" class="form-control" placeholder="Ej: 100.50" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="form-label" for="green_density">Densidad Verde</label>
                        <input id="green_density" name="green_density" type="text" class="form-control" placeholder="g/cm³">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="green_humidity">Humedad Verde</label>
                        <input id="green_humidity" name="green_humidity" type="text" class="form-control" placeholder="%">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="tag">Etiqueta</label>
                        <input id="tag" name="tag" type="text" class="form-control" placeholder="Ej: LOTE-001">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="peel_stick">Cascarilla/Stick</label>
                        <select id="peel_stick" name="peel_stick" class="form-select">
                            <option value="no">No</option>
                            <option value="yes">Sí</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label" for="printed_label">Etiqueta Impresa</label>
                        <select id="printed_label" name="printed_label" class="form-select">
                            <option value="no">No</option>
                            <option value="yes">Sí</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="urgent_order">¿Urgente?</label>
                        <select id="urgent_order" name="urgent_order" class="form-select">
                            <option value="no">No</option>
                            <option value="yes">Sí</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="status">Estado</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="pending">Pendiente</option>
                            <option value="in_progress">En proceso</option>
                            <option value="completed">Completado</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="observations">Observaciones</label>
                    <textarea id="observations" name="observations" class="form-control" rows="3" placeholder="Notas adicionales sobre el pedido"></textarea>
                </div>
            </div>

            <!-- Maquila Services Section -->
            <div class="section-card">
                <h5><i class="fas fa-tools"></i> Servicios de Maquila</h5>
                
                <div class="row g-3 mb-3 align-items-end">
                    <div class="col-md-8">
                        <label class="form-label">Cantidad de servicios a añadir</label>
                        <select id="services_count" class="form-select">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
                
                <div id="servicesContainer" class="mb-3"></div>
            </div>

            <!-- Maquila Meshes Section -->
            <div class="section-card">
                <h5><i class="fas fa-th"></i> Mallas Utilizadas</h5>
                
                <div class="row g-3 mb-3 align-items-end">
                    <div class="col-md-8">
                        <label class="form-label">Cantidad de mallas a añadir</label>
                        <select id="meshes_count" class="form-select">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
                
                <div id="meshesContainer" class="mb-3"></div>
            </div>

            <!-- Maquila Packages Section -->
            <div class="section-card">
                <h5><i class="fas fa-box"></i> Empaquetado</h5>
                
                <div class="row g-3 mb-3 align-items-end">
                    <div class="col-md-8">
                        <label class="form-label">Cantidad de paquetes a añadir</label>
                        <select id="packages_count" class="form-select">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
                
                <div id="packagesContainer" class="mb-3"></div>
            </div>

            <button type="submit" class="btn btn-cafe">
                <i class="fas fa-save"></i> Guardar Pedido Maquila
            </button>
            <a href="{{ route('maquila-orders.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Cancelar
            </a>
        </form>
    </div>

</div>

@include('footer')

<script>
    (function () {
        const servicesCount = document.getElementById('services_count');
        const meshesCount = document.getElementById('meshes_count');
        const packagesCount = document.getElementById('packages_count');
        const servicesContainer = document.getElementById('servicesContainer');
        const meshesContainer = document.getElementById('meshesContainer');
        const packagesContainer = document.getElementById('packagesContainer');

        // Service block template
        function serviceBlockTemplate(index) {
            return `
            <div class="card mb-2" data-type="service" data-index="${index}">
                <div class="card-body p-3">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-10">
                            <label class="form-label">Servicio</label>
                            <select name="maquila_services[${index}][service_id]" class="form-select form-select-sm" required>
                                <option value="">-- Seleccione servicio --</option>
                                     @foreach($services as $s)
                                        <option value="{{ $s->id }}">{{ $s->service_type }}</option>
                                     @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm remove-item">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
            `;
        }

        // Mesh block template
        function meshBlockTemplate(index) {
            return `
            <div class="card mb-2" data-type="mesh" data-index="${index}">
                <div class="card-body p-3">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-10">
                            <label class="form-label">Malla</label>
                            <select name="maquila_meshes[${index}][meshe_id]" class="form-select form-select-sm" required>
                                <option value="">-- Seleccione malla --</option>
                                     @foreach($meshes as $m)
                                        <option value="{{ $m->id }}">{{ $m->meshe_type }} ({{ $m->weight }})</option>
                                     @endforeach

                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm remove-item">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
            `;
        }

        // Package block template
        function packageBlockTemplate(index) {
            return `
            <div class="card mb-2" data-type="package" data-index="${index}">
                <div class="card-body p-3">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label">Tipo de Paquete</label>
                            <select name="maquila_packages[${index}][package_id]" class="form-select form-select-sm" required>
                                <option value="">-- Seleccione paquete --</option>
                                     @foreach($packages as $p)
                                        <option value="{{ $p->id }}">{{ $p->package_type }}</option>
                                     @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Medida</label>
                            <select name="maquila_packages[${index}][measure_id]" class="form-select form-select-sm" required>
                                <option value="">-- Seleccione medida --</option>
                                     @foreach($measures as $m)
                                        <option value="{{ $m->id }}">{{ $m->measure_type }}</option>
                                     @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Kilogramos</label>
                            <input type="number" step="0.01" min="0" name="maquila_packages[${index}][kilograms]" class="form-control form-control-sm" placeholder="0.00" required>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-sm remove-item">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
            `;
        }

        // Render blocks
        function renderBlocks(type, count) {
            const container = type === 'service' ? servicesContainer : type === 'mesh' ? meshesContainer : packagesContainer;
            const template = type === 'service' ? serviceBlockTemplate : type === 'mesh' ? meshBlockTemplate : packageBlockTemplate;
            
            container.innerHTML = '';
            for (let i = 0; i < count; i++) {
                container.insertAdjacentHTML('beforeend', template(i));
            }
            attachRemoveHandlers();
        }

        // Attach remove handlers
        function attachRemoveHandlers() {
            document.querySelectorAll('.remove-item').forEach(btn => {
                btn.onclick = function (e) {
                    e.preventDefault();
                    const card = this.closest('.card');
                    const type = card.getAttribute('data-type');
                    card.remove();
                    renumberBlocks(type);
                    updateCounts();
                };
            });
        }

        // Renumber blocks
        function renumberBlocks(type) {
            const container = type === 'service' ? servicesContainer : type === 'mesh' ? meshesContainer : packagesContainer;
            container.querySelectorAll('.card').forEach((card, idx) => {
                card.setAttribute('data-index', idx);
                const selects = card.querySelectorAll('select, input');
                selects.forEach(el => {
                    const name = el.getAttribute('name');
                    if (name) {
                        if (type === 'service') {
                            if (name.includes('service_id')) el.setAttribute('name', `maquila_services[${idx}][service_id]`);
                        } else if (type === 'mesh') {
                            if (name.includes('meshe_id')) el.setAttribute('name', `maquila_meshes[${idx}][meshe_id]`);
                        } else if (type === 'package') {
                            if (name.includes('package_id')) el.setAttribute('name', `maquila_packages[${idx}][package_id]`);
                            if (name.includes('measure_id')) el.setAttribute('name', `maquila_packages[${idx}][measure_id]`);
                            if (name.includes('kilograms')) el.setAttribute('name', `maquila_packages[${idx}][kilograms]`);
                        }
                    }
                });
            });
        }

        // Update counts
        function updateCounts() {
            servicesCount.value = servicesContainer.querySelectorAll('.card').length.toString();
            meshesCount.value = meshesContainer.querySelectorAll('.card').length.toString();
            packagesCount.value = packagesContainer.querySelectorAll('.card').length.toString();
        }

        // Event listeners
        servicesCount.addEventListener('change', function () {
            renderBlocks('service', parseInt(this.value, 10) || 0);
        });

        meshesCount.addEventListener('change', function () {
            renderBlocks('mesh', parseInt(this.value, 10) || 0);
        });

        packagesCount.addEventListener('change', function () {
            renderBlocks('package', parseInt(this.value, 10) || 0);
        });

        // Initial state
        renderBlocks('service', 0);
        renderBlocks('mesh', 0);
        renderBlocks('package', 0);
    })();
</script>

</body>
</html>