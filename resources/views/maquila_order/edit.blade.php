@include('navbar')

<div class="container mt-4">
    <div class="cafe-section">
        <h3 class="mb-3">Editar Pedido Maquila</h3>

        <form id="maquilaOrderForm" action="{{ route('maquila-orders.update', $maquilaOrder->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label" for="user_id">Trabajador</label>
                    <select id="user_id" name="user_id" class="form-select" required>
                        <option value="{{ Auth::user()->id }}" selected>{{ Auth::user()->name }}</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="costumer_id">Cliente</label>
                    <div class="input-group">
                        <select id="costumer_id" name="costumer_id" class="form-select" required>
                            <option value="">-- Seleccione cliente --</option>
                            @foreach($costumers as $c)
                                <option value="{{ $c->id }}" {{ old('costumer_id', $maquilaOrder->costumer_id) == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }} — {{ $c->farm ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#newCostumerModal">
                            <i class="fas fa-plus"></i> Nuevo
                        </button>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="entry_date">Fecha de entrada</label>
                    <input id="entry_date" name="entry_date" type="date" class="form-control" required
                        value="{{ old('entry_date', $maquilaOrder->entry_date) }}">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label" for="coffe_type">Tipo de Café</label>
                    <select id="coffe_type" name="coffe_type" class="form-select" required>
                        <option value="">-- Seleccione calidad --</option>
                        <option value="tostado" {{ old('coffe_type', $maquilaOrder->coffe_type) == 'tostado' ? 'selected' : '' }}>Tostado</option>
                        <option value="almendra" {{ old('coffe_type', $maquilaOrder->coffe_type) == 'almendra' ? 'selected' : '' }}>Almendra</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="quality_type">Tipo de Calidad</label>
                    <select id="quality_type" name="quality_type" class="form-select" required>
                        <option value="">-- Seleccione calidad --</option>
                        <option value="CPS" {{ old('quality_type', $maquilaOrder->quality_type) == 'CPS' ? 'selected' : '' }}>CPS</option>
                        <option value="Honey" {{ old('quality_type', $maquilaOrder->quality_type) == 'Honey' ? 'selected' : '' }}>Honey</option>
                        <option value="Natural" {{ old('quality_type', $maquilaOrder->quality_type) == 'Natural' ? 'selected' : '' }}>Natural</option>
                        <option value="Excelso" {{ old('quality_type', $maquilaOrder->quality_type) == 'Excelso' ? 'selected' : '' }}>Excelso</option>
                        <option value="Subproudcto" {{ old('quality_type', $maquilaOrder->quality_type) == 'Subproudcto' ? 'selected' : '' }}>Subproducto</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="toast_type">Tipo de Tostado</label>
                    <select id="toast_type" name="toast_type" class="form-select" required>
                        <option value="">-- Seleccione tostado --</option>
                        <option value="claro" {{ old('toast_type', $maquilaOrder->toast_type) == 'claro' ? 'selected' : '' }}>Bajo</option>
                        <option value="medio" {{ old('toast_type', $maquilaOrder->toast_type) == 'medio' ? 'selected' : '' }}>Medio</option>
                        <option value="mediobajo" {{ old('toast_type', $maquilaOrder->toast_type) == 'mediobajo' ? 'selected' : '' }}>MedioAlto</option>
                        <option value="alta" {{ old('toast_type', $maquilaOrder->toast_type) == 'alta' ? 'selected' : '' }}>Alta</option>
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label" for="recieved_kilograms">Kilogramos Recibidos</label>
                    <input id="recieved_kilograms" name="recieved_kilograms" type="number" step="0.01"
                        class="form-control"
                        value="{{ old('recieved_kilograms', $maquilaOrder->recieved_kilograms) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tipo de empaque</label>
                    <select id="packaging_type" name="packaging_type" class="form-select">
                        <option value="estopa" {{ old('packaging_type', $maquilaOrder->packaging_type) == 'estopa' ? 'selected' : '' }}>Estopa</option>
                        <option value="bulto" {{ old('packaging_type', $maquilaOrder->packaging_type) == 'bulto' ? 'selected' : '' }}>Bulto</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Cantidad</label>
                    <input id="packaging_quantity" onchange="kilosNetos()" name="packaging_quantity" type="number" step="1"
                        class="form-control" value="{{ old('packaging_quantity', $maquilaOrder->packaging_quantity) }}">
                </div>

                <div class="col-md-4 mt-3">
                    <label class="form-label">Kilos netos</label>
                    <input id="net_weight" name="net_weight" type="number" step="0.01" class="form-control"
                        value="{{ old('net_weight', $maquilaOrder->net_weight) }}">
                </div>

                <div class="col-md-4">
    <label class="form-label" for="tag">Etiqueta Impresa</label>
    <select id="tag" name="tag" class="form-select">
        <option value="no" {{ old('tag', $maquilaOrder->tag) == 'no' ? 'selected' : '' }}>No</option>
        <option value="yes" {{ old('tag', $maquilaOrder->tag) == 'yes' ? 'selected' : '' }}>Sí</option>
    </select>
</div>

<div class="col-md-4">
    <label class="form-label" for="peel_stick">Cascarilla/Stick</label>
    <select id="peel_stick" name="peel_stick" class="form-select">
        <option value="no" {{ old('peel_stick', $maquilaOrder->peel_stick) == 'no' ? 'selected' : '' }}>No</option>
        <option value="yes" {{ old('peel_stick', $maquilaOrder->peel_stick) == 'yes' ? 'selected' : '' }}>Sí</option>
    </select>
</div>

<div class="col-md-4">
        <label class="form-label" for="printed_label">Etiqueta Impresa</label>
        <select id="printed_label" name="printed_label" class="form-select">
            <option value="no" {{ old('printed_label', $maquilaOrder->printed_label) == 'no' ? 'selected' : '' }}>No</option>
            <option value="yes" {{ old('printed_label', $maquilaOrder->printed_label) == 'yes' ? 'selected' : '' }}>Sí</option>
        </select>
    </div>

    <div class="col-md-4">
    <label class="form-label" for="urgent_order">¿Urgente?</label>
    <select id="urgent_order" name="urgent_order" class="form-select">
        <option value="no" {{ old('urgent_order', $maquilaOrder->urgent_order) == 'no' ? 'selected' : '' }}>No</option>
        <option value="yes" {{ old('urgent_order', $maquilaOrder->urgent_order) == 'yes' ? 'selected' : '' }}>Sí</option>
    </select>
</div>

                <div class="col-md-4 mt-3">
                    <label class="form-label">Densidad Verde</label>
                    <input id="green_density" name="green_density" type="text" class="form-control"
                        value="{{ old('green_density', $maquilaOrder->green_density) }}">
                </div>

                <div class="col-md-4 mt-3">
                    <label class="form-label">Humedad Verde</label>
                    <input id="green_humidity" name="green_humidity" type="text" class="form-control"
                        value="{{ old('green_humidity', $maquilaOrder->green_humidity) }}">
                </div>
            </div>

            {{-- Services --}}
            <div class="d-flex flex-wrap gap-3 mb-3">
                @foreach($services as $index => $service)
            @php
                $selected = $maquilaOrder->maquila_services->firstWhere('service_id', $service->id)->selection ?? 'no';
            @endphp

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
                            {{ $selected == 'no' ? 'checked' : '' }}>
                        <label class="btn btn-sm btn-outline-secondary" for="service-{{ $service->id }}-no">No</label>
                    </div>

                    {{-- SI --}}
                    <div class="text-center">
                        <input type="radio"
                            class="btn-check"
                            name="maquila_services[{{ $index }}][selection]"
                            id="service-{{ $service->id }}-yes"
                            value="yes"
                            autocomplete="off"
                            {{ $selected == 'yes' ? 'checked' : '' }}>
                        <label class="btn btn-sm btn-outline-success" for="service-{{ $service->id }}-yes">Sí</label>
                    </div>

                </div>
            </div>
        @endforeach
            </div>

            {{-- Meshes --}}
            <div class="section-card mt-4 mb-3">
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
                            @foreach($maquilaOrder->maquila_meshes as $index => $mesh)
                                <tr>
                                    <td>
                                        <input type="hidden" name="maquila_meshes[{{ $index }}][meshe_id]" value="{{ $mesh->meshe_id }}">
                                        <strong>{{ $mesh->mesh->meshe_type }}</strong>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" min="0" name="maquila_meshes[{{ $index }}][weight]" class="form-control form-control-sm"
                                            value="{{ $mesh->weight }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Packages --}}
            <div class="section-card mb-3">
                <h5><i class="fas fa-box"></i> Empaquetado</h5>
                <button type="button" class="btn btn-primary mb-3" onclick="addPackageForm()">Añadir paquete</button>
                <div id="packagesContainer">
                    @foreach($maquilaOrder->maquila_packages as $i => $pkg)
                        <div class="row g-3 align-items-end mb-3" data-index="{{ $i }}">
                            <div class="col-md-3">
                                <label class="form-label">Tipo de paquete</label>
                                <select name="maquila_packages[{{ $i }}][type]" class="form-select">
                                    @foreach($packages as $p)
                                        <option value="{{ $p->package_type }}" {{ $pkg->package->package_type == $p->package_type ? 'selected' : '' }}>
                                            {{ $p->package_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Malla</label>
                                <select name="maquila_packages[{{$i}}][mesh]" class="form-select">
                                    <option value="">Seleccione...</option>
                                    <option value="malla_18">Malla 18</option>
                                    <option value="malla_17">Malla 17</option>
                                    <option value="malla_15">Malla 15</option>
                                    <option value="malla_14">Malla 14</option>
                                    <option value="fondo">Fondo</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Presentación</label>
                                <input type="text" name="maquila_packages[{{ $i }}][presentation]" class="form-control"
                                    value="{{ $pkg->presentation }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Kilos</label>
                                <input type="number" step="0.01" name="maquila_packages[{{ $i }}][kilograms]" class="form-control"
                                    value="{{ $pkg->kilograms }}">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger w-100" onclick="removePackageForm({{ $i }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-cafe"><i class="fas fa-save"></i> Actualizar Pedido Maquila</button>
                <a href="{{ route('maquila-orders.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@include('footer')

<script>
let packageOptions = `
        @foreach($packages as $package)
            <option value="{{ $package->package_type }}">{{ $package->package_type }}</option>
        @endforeach
    `;

function addPackageForm() {
    const container = document.getElementById("packagesContainer");
    const wrapper = document.createElement("div");
    wrapper.classList.add("row", "g-3", "align-items-end", "mb-3");
    wrapper.setAttribute("data-index", packageIndex);

    wrapper.innerHTML = `
        <div class="col-md-3">
            <label class="form-label">Tipo de paquete</label>
            <select name="maquila_packages[${packageIndex}][type]" class="form-select">
                ${packageOptions}
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Malla</label>
            <select name="maquila_packages[${packageIndex}][mesh]" class="form-select">
                <option value="">Seleccione...</option>
                <option value="malla_18">Malla 18</option>
                <option value="malla_17">Malla 17</option>
                <option value="malla_15">Malla 15</option>
                <option value="malla_14">Malla 14</option>
                <option value="fondo">Fondo</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Presentación</label>
            <select name="maquila_packages[${packageIndex}][presentation]" class="form-select">
                <option value="">Seleccione...</option>
                <option value="250">250g</option>
                <option value="340">340g</option>
                <option value="500">500g</option>
                <option value="1000">1000g</option>
                <option value="2500">2500g</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Kilos</label>
            <input type="number" step="0.01" name="maquila_packages[${packageIndex}][kilograms]" class="form-control">
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

function kilosNetos() {
    var packagingType = document.getElementById("packaging_type").value;
    var packagingQuantity = parseFloat(document.getElementById("packaging_quantity").value) || 0;
    var recieved_kilograms = parseFloat(document.getElementById("recieved_kilograms").value) || 0;
    var netWeightPerUnit = 0;

    if (packagingType === "estopa") netWeightPerUnit = 0.150;
    else if (packagingType === "bulto") netWeightPerUnit = 0.7;

    var totalNetWeight = recieved_kilograms - (packagingQuantity * netWeightPerUnit);
    document.getElementById("net_weight").value = totalNetWeight.toFixed(2);
}
</script>
