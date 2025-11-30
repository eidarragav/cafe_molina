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

                <div class="col-md-4">
                    <label class="form-label" for="departure_date">Fecha de salida</label>
                    <input id="departure_date" name="departure_date" type="date" class="form-control" 
                        value="{{ old('departure_date', $maquilaOrder->entry_date) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="urgent_order">¿Urgente?</label>
                    <select id="urgent_order" name="urgent_order" class="form-select">
                        <option value="no" {{ old('urgent_order', $maquilaOrder->urgent_order) == 'no' ? 'selected' : '' }}>No</option>
                        <option value="yes" {{ old('urgent_order', $maquilaOrder->urgent_order) == 'yes' ? 'selected' : '' }}>Sí</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="management_criteria">Criterio gerencial</label>
                    <select id="management_criteria" name="management_criteria" class="form-select">
                        <option value="no" {{ old('management_criteria', $maquilaOrder->management_criteria) == 'no' ? 'selected' : '' }}>No</option>
                        <option value="yes" {{ old('management_criteria', $maquilaOrder->management_criteria) == 'yes' ? 'selected' : '' }}>Sí</option>
                    </select>
                </div>
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
