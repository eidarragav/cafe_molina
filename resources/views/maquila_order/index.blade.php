

@include('navbar')

<div class="container mt-4">
    <div class="cafe-section">
        <h3 class="mb-3">Crear Pedido Maquila</h3>

        <form id="maquilaOrderForm" action="{{ route('maquila-orders.store') }}" method="POST">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label" for="user_id">Trabajor</label>
                    <select id="user_id" name="user_id" class="form-select" required>
                                <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>                            
                    </select>
                </div>

                <div class="col-md-4">
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

                <div class="col-md-4">
                    <label class="form-label" for="departure_date" >Fecha de entrada</label>
                    <input id="departure_date" name="entry_date" type="date" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="departure_date" >Fecha de salida</label>
                    <input id="departure_date" name="departure_date" type="date" class="form-control" >
                </div>
            </div>

            <div class="row g-3 mb-3">
                

                <div class="col-md-4">
                    <label class="form-label" for="coffe_type">Tipo de Café</label>
                    <select id="coffe_type" name="coffe_type" class="form-select" required>
                        <option value="">-- Seleccione calidad --</option>
                        <option value="tostado">Tostado</option>
                        <option value="almendra">Almendra</option>

                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="quality_type">Tipo de Calidad</label>
                    <select id="quality_type" name="quality_type" class="form-select" required>
                        <option value="">-- Seleccione calidad --</option>
                        <option value="CPS">CPS</option>
                        <option value="Honey">Honey</option>
                        <option value="Natural">Natural</option>
                        <option value="Excelso">Excelso</option>
                        <option value="Subproudcto">Subproudcto</option>
                        
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="toast_type">Tipo de Tostado</label>
                    <select id="toast_type" name="toast_type" class="form-select" required>
                        <option value="">-- Seleccione tostado --</option>
                        <option value="claro">Bajo</option>
                        <option value="medio">Medio</option>
                        <option value="mediobajo">MedioAlto</option>
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
                    <label class="form-label" for="">Tipo de empaque</label>
                    <select id="packaging_type" name="packaging_type" class="form-select">
                        <option value="estopa">Estopa</option>
                        <option value="bulto">Bulto</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="">Cantidad</label>
                    <input id="packaging_quantity" onchange="kilosNetos()" name="packaging_quantity" type="number" step="1" class="form-control" placeholder="" required>
                </div>

                <script>
                    function kilosNetos() {
                        var packagingType = document.getElementById("packaging_type").value;
                        var packagingQuantity = parseFloat(document.getElementById("packaging_quantity").value) || 0;
                        var recieved_kilograms = document.getElementById("recieved_kilograms").value;
                        var netWeightPerUnit = 0;

                        if (packagingType === "estopa") {
                            netWeightPerUnit = 0.150; // Peso neto para estopa
                        } else if (packagingType === "bulto") {
                            netWeightPerUnit = 0.7; // Peso neto para bulto
                        }

                        var totalNetWeight = recieved_kilograms - (packagingQuantity * netWeightPerUnit);
                        document.getElementById("net_weight").value = totalNetWeight.toFixed(2);
                    }
                </script>

                <div class="col-md-4">
                    <label class="form-label" for="recieved_kilograms">Kilos netos</label>
                    <input onchange="departure_date()" id="net_weight" name="net_weight" type="number" step="0.01" class="form-control" placeholder="Ej: 100.50" required>
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

                <div class="col-md-4">
                    <label class="form-label" for="management_criteria">Criterio gerencial</label>
                    <select id="management_criteria" name="management_criteria" class="form-select" required>
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
            <div class="d-flex flex-wrap gap-3">

                @foreach($services as $index => $service)

                    <div class="card shadow-sm p-3" style="min-width: 220px;">
                        <strong>{{ $service->service_type }}</strong>
                        <input type="hidden" name="maquila_services[{{ $index }}][service_id]" value="{{ $service->id }}">

                        <div class="d-flex justify-content-between mt-2">

                            {{-- NO --}}
                            <div class="text-center">
                                <input type="radio"
                                    class="btn-check"
                                    name="maquila_services[{{ $index }}][selection]"
                                    id="service-{{ $service->id }}-no"
                                    value="no"
                                    autocomplete="off"
                                    checked>
                                <label class="btn btn-sm btn-outline-secondary" for="service-{{ $service->id }}-no">No</label>
                            </div>

                            {{-- SI --}}
                            <div class="text-center">
                                <input type="radio"
                                    class="btn-check"
                                    name="maquila_services[{{ $index }}][selection]"
                                    id="service-{{ $service->id }}-yes"
                                    value="yes"
                                    autocomplete="off">
                                <label class="btn btn-sm btn-outline-success" for="service-{{ $service->id }}-yes">Sí</label>
                            </div>
                        </div>
                    </div>

                @endforeach

            </div>

            <!-- Maquila Meshes Section -->
            <div class="section-card mt-4">
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
                
                <button type="button" class="btn btn-primary mb-3" onclick="addPackageForm()">
                    Añadir paquete
                </button>

                <div id="packagesContainer"></div>
            </div>

            <script>
                let packageIndex = 0;

                function addPackageForm() {
                    const container = document.getElementById("packagesContainer");

                    const wrapper = document.createElement("div");
                    wrapper.classList.add("row", "g-3", "align-items-end", "mb-3");
                    wrapper.setAttribute("data-index", packageIndex);

                    wrapper.innerHTML = `
                        <div class="col-md-3">
                            <label class="form-label">Tipo de paquete</label>
                            <select name="packages[${packageIndex}][type]" class="form-select">
                                <option value="">Seleccione...</option>

                                @foreach($packages as $package)
                                    <option value="{{ $package->package_type }}">
                                        {{ $package->package_type }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Malla</label>
                            <select name="packages[${packageIndex}][mesh]" class="form-select">
                                <option value="">Seleccione...</option>
                                <option value="malla_18">Malla 18</option>
                                <option value="malla_17">Malla 17</option>
                                <option value="malla_15">Malla 15</option>
                                <option value="malla_14">Malla 14</option>
                                <option value="fondo">Fondo</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Presentacion</label>
                            <select name="packages[${packageIndex}][presentation]" class="form-select">
                                <option value="">Seleccione...</option>
                                <option value="250">250g</option>
                                <option value="340">340g</option>
                                <option value="500">500g</option>
                                <option value="1000">1000g</option>
                                <option value="2500">2500g</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Kilos</label>
                            <input type="number" name="packages[${packageIndex}][kilograms]" step="0.01" class="form-control">
                        </div>

                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger w-100" onclick="removePackageForm(${packageIndex})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;

                    container.appendChild(wrapper);
                    packageIndex++;
                }

                function removePackageForm(index) {
                    const element = document.querySelector(`[data-index="${index}"]`);
                    if (element) element.remove();
                }
            </script>

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