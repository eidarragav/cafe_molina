

@include('navbar')

<div class="container mt-4">
    <div class="cafe-section">
        <h3 class="mb-3">Crear Pedido Maquila</h3>

        <form id="maquilaOrderForm" action="{{ route('maquila-orders.store') }}" method="POST">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label" for="user_id">Trabajor</label>
                    <select id="user_id" name="user_id" class="form-select" required>
                                <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>                            
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="costumer_id">Cliente</label>
                    <div class="input-group">
                        <select id="costumer_id" name="costumer_id" class="form-select" required>
                            <option value="">-- Seleccione cliente --</option>
                            @foreach($costumers as $c)
                                <option value="{{ $c->id }}">{{ $c->name }} — {{ $c->farm ?? '' }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#newCostumerModal">
                            <i class="fas fa-plus"></i> Nuevo
                        </button>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label" for="coffe_type">Tipo de Café</label>
                    <input id="coffe_type" name="coffe_type" type="text" class="form-control" placeholder="Ej: Arábica, Robusta" required>
                </div>

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
                        <option value="claro">Bajo</option>
                        <option value="medio">Medio</option>
                        <option value="mediobajo">MedioBajo</option>
                        <option value="alta">Alta</option>
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label" for="recieved_kilograms">Kilogramos Recibidos</label>
                    <input id="recieved_kilograms" name="recieved_kilograms" type="number" step="0.01" class="form-control" placeholder="Ej: 100.50" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="green_density">Densidad Verde</label>
                    <input id="green_density" name="green_density" type="text" class="form-control" placeholder="g/cm³">
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="green_humidity">Humedad Verde</label>
                    <input id="green_humidity" name="green_humidity" type="text" class="form-control" placeholder="%">
                </div>
            </div>

            <div class="row g-3 mb-3">
                
                <div class="col-md-4">
                    <label class="form-label" for="tag">Etiqueta Impresa</label>
                    <select id="tag" name="tag" class="form-select">
                        <option value="no">No</option>
                        <option value="yes">Sí</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="peel_stick">Cascarilla/Stick</label>
                    <select id="peel_stick" name="peel_stick" class="form-select">
                        <option value="no">No</option>
                        <option value="yes">Sí</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="printed_label">Etiqueta Impresa</label>
                    <select id="printed_label" name="printed_label" class="form-select">
                        <option value="no">No</option>
                        <option value="yes">Sí</option>
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label" for="urgent_order">¿Urgente?</label>
                    <select id="urgent_order" name="urgent_order" class="form-select">
                        <option value="no">No</option>
                        <option value="yes">Sí</option>
                    </select>
                </div>

            
            </div>

            <div class="mb-3">
                <label class="form-label" for="observations">Observaciones</label>
                <textarea id="observations" name="observations" class="form-control" rows="3" placeholder="Notas adicionales sobre el pedido"></textarea>
            </div>

            <!-- Maquila Services Section -->
            <div class="section-card">
                <h5><i class="fas fa-tools"></i> Servicios de Maquila</h5>

                <p class="small-muted">Seleccione si se usará cada servicio (Sí / No). Se enviará un registro por cada servicio.</p>

                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead style="background-color: var(--cafe-primary); color: var(--cafe-accent)">
                            <tr>
                                <th>Servicio</th>
                                <th class="text-center">No</th>
                                <th class="text-center">Sí</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $index => $service)
                                <tr>
                                    <td>
                                        <input type="hidden" name="maquila_services[{{ $index }}][service_id]" value="{{ $service->id }}">
                                        <strong>{{ $service->service_type }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <input type="radio" class="btn-check" name="maquila_services[{{ $index }}][selection]" id="service-{{ $service->id }}-no" value="no" autocomplete="off" checked>
                                        <label class="btn btn-sm btn-outline-secondary" for="service-{{ $service->id }}-no">No</label>
                                    </td>
                                    <td class="text-center">
                                        <input type="radio" class="btn-check" name="maquila_services[{{ $index }}][selection]" id="service-{{ $service->id }}-yes" value="yes" autocomplete="off">
                                        <label class="btn btn-sm btn-outline-success" for="service-{{ $service->id }}-yes">Sí</label>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Maquila Meshes Section -->
            <div class="section-card">
                <h5><i class="fas fa-th"></i> Mallas Utilizadas</h5>
                
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead style="background-color: var(--cafe-primary); color: var(--cafe-accent)">
                            <tr>
                                <th>Malla</th>
                                <th>Peso (kg)</th>
                            </tr>
                        </thead>
                        <tbody id="meshesTableBody">
                            <!-- All meshes will be inserted here -->
                        </tbody>
                    </table>
                </div>
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

            <div class="mt-3">
                <button type="submit" class="btn btn-cafe"><i class="fas fa-save"></i> Guardar Pedido Maquila</button>
                <a href="{{ route('maquila-orders.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<!-- New Costumer Modal -->
<div class="modal fade" id="newCostumerModal" tabindex="-1" aria-labelledby="newCostumerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="newCostumerForm" method="POST" action="{{ route('costumers.store') }}">
                @csrf
                <div class="modal-header" style="background:var(--cafe-primary); color:var(--cafe-accent)">
                    <h5 class="modal-title" id="newCostumerLabel">Crear Cliente</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div id="costumerErrors" class="alert alert-danger d-none"></div>

                    <div class="mb-3">
                        <label for="cost_name" class="form-label">Nombre</label>
                        <input id="cost_name" name="name" type="text" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="cost_cedula" class="form-label">Cédula</label>
                        <input id="cost_cedula" name="cedula" type="text" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="cost_phone" class="form-label">Teléfono</label>
                        <input id="cost_phone" name="phone" type="text" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="cost_farm" class="form-label">Finca</label>
                        <input id="cost_farm" name="farm" type="text" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-cafe">Crear y seleccionar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('footer')

<script>
    (function () {
    const form = document.getElementById('newCostumerForm');
    const modalEl = document.getElementById('newCostumerModal');
    const costumerSelect = document.getElementById('costumer_id');
    const errorsBox = document.getElementById('costumerErrors');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        errorsBox.classList.add('d-none');
        errorsBox.innerHTML = '';

        const url = form.getAttribute('action');

        // Obtener token de forma segura (fallback al _token del form si no hay meta)
        let token = null;
        const meta = document.querySelector('meta[name="csrf-token"]');
        if (meta) token = meta.getAttribute('content');
        if (!token) {
            // buscar campo _token dentro del form (because @csrf pone un input hidden)
            const tokenInput = form.querySelector('input[name="_token"]');
            if (tokenInput) token = tokenInput.value;
        }

        const data = new FormData(form);

        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    // solo añadir header si token existe
                    ...(token ? {'X-CSRF-TOKEN': token} : {}),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: data
            });

            // debug: imprime status y headers
            console.log('Fetch status:', res.status);

            // intenta parsear JSON; si no es JSON, lo mostramos como texto para debugging
            let json = null;
            try {
                json = await res.json();
            } catch (parseErr) {
                const txt = await res.text();
                console.warn('Respuesta no JSON:', txt);
                // mostrar el texto en el cuadro de errores si es HTML
                errorsBox.innerHTML = txt;
                errorsBox.classList.remove('d-none');
                return;
            }

            // Si no OK, mostrar errores retornados (422, 419...)
            if (!res.ok) {
                const messages = [];
                if (json && json.errors) {
                    for (const k in json.errors) {
                        messages.push(...json.errors[k]);
                    }
                } else if (json && json.message) {
                    messages.push(json.message);
                } else {
                    messages.push('Error al crear el cliente.');
                }
                errorsBox.innerHTML = messages.map(m => `<div>${m}</div>`).join('');
                errorsBox.classList.remove('d-none');
                return;
            }

            // Success - soporte varias formas de payload
            const created = (json && json.costumer) ? json.costumer : (json && json.id ? json : null);

            console.log('Respuesta JSON:', json, 'Created:', created);

            if (created && created.id) {
                const optionText = created.name + (created.farm ? ' — ' + created.farm : '');
                const newOpt = new Option(optionText, created.id, true, true);
                costumerSelect.add(newOpt);
                costumerSelect.value = created.id;
            } else {
                // Si la respuesta no contiene el objeto esperado, lo mostramos para depuración
                errorsBox.innerHTML = '<div>Respuesta inesperada del servidor. Revisa la consola Network.</div>';
                errorsBox.classList.remove('d-none');
                return;
            }

            // cerrar modal
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();

            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            document.body.style.overflow = '';
            document.body.classList.remove('modal-open');

            form.reset();

        } catch (err) {
            console.error('Error fetch:', err);
            errorsBox.innerHTML = 'No se pudo conectar con el servidor.';
            errorsBox.classList.remove('d-none');
        }
    });
})();

    (function () {
        const meshesTableBody = document.getElementById('meshesTableBody');
        const meshesData = @json($meshes);

        function initializeMeshes() {
            meshesTableBody.innerHTML = '';
            
            meshesData.forEach((mesh, index) => {
                const row = document.createElement('tr');
                row.setAttribute('data-mesh-id', mesh.id);
                row.innerHTML = `
                    <td>
                        <input type="hidden" name="maquila_meshes[${index}][meshe_id]" value="${mesh.id}">
                        <strong>${mesh.meshe_type}</strong>
                    </td>
                    <td>
                        <input type="number" step="0.01" min="0" name="maquila_meshes[${index}][weight]" class="form-control form-control-sm" placeholder="0.00">
                    </td>
                `;
                meshesTableBody.appendChild(row);
            });
        }

        // Initialize all meshes on page load
        initializeMeshes();
    })();
</script>

</body>
</html>