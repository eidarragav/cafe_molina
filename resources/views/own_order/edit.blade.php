@include('navbar')

<style>
    .brand-section {
        background-color: #f7faf4;
        border-left: 6px solid #556B2F;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 6px 18px rgba(85, 107, 47, 0.15);
        margin-bottom: 1.5rem;
    }
    .btn-olive {
        background-color: #556B2F;
        color: white;
        border: none;
        transition: background-color 0.3s;
    }
    .btn-olive:hover, .btn-olive:focus {
        background-color: #8DB600;
        color: white;
    }
</style>

<div class="container mt-4">

    <div class="brand-section">
        <h3>📝 Editar Pedido Propio</h3>

        <form id="ownOrderForm" action="{{ route('own-orders.update', $ownOrder->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label" for="user_id">Usuario</label>
                    <select id="user_id" name="user_id" class="form-select" required>
                        <option value="{{ Auth::user()->id }}" selected>{{ Auth::user()->name }}</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="costumer_id">Cliente</label>
                    <div class="input-group">
                        <select id="costumer_id" name="costumer_id" class="form-select" >
                            <option value="">{{$costumer->name}}</option>
                        </select>
                        
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="entry_date">Fecha de entrada</label>
                    <input id="entry_date" name="entry_date" type="date" class="form-control" required 
                    onchange="update_dpdate()" value="{{ $ownOrder->entry_date ? \Carbon\Carbon::parse($ownOrder->entry_date)->format('Y-m-d') : '' }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="departure_date">Fecha de salida</label>
                    <input id="departure_date" name="departure_date" type="date" class="form-control" value="{{ $ownOrder->departure_date }}" >
                </div>
            </div>

            <div class="row g-3 mb-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label" for="urgent_select">¿Urgente?</label>
                    <select id="urgent_select" name="urgent_order" class="form-select" required>
                        <option value="no" @if($ownOrder->urgent_order == 'no') selected @endif>No</option>
                        <option value="yes" @if($ownOrder->urgent_order == 'yes') selected @endif>Sí</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="management_criteria">Criterio gerencial</label>
                    <select id="management_criteria" name="management_criteria" class="form-select" required>
                        <option value="no" @if($ownOrder->management_criteria == 'no') selected @endif>No</option>
                        <option value="yes" @if($ownOrder->management_criteria == 'yes') selected @endif>Sí</option>
                    </select>
                </div>

            </div>

            <hr>

        
            <button type="submit" class="btn btn-olive">Actualizar Pedido</button>
            <a href="{{ route('own-orders.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

</div>

<!-- Reutilizamos el modal de nuevo cliente igual que en create -->

<script>
(function () {
    const productsCount = document.getElementById('products_count');
    const container = document.getElementById('productsContainer');

    
    // Render N new blocks
    function renderBlocks(n) {
        const existing = container.querySelectorAll('.card').length;
        for (let i = existing; i < existing + n; i++) {
            container.insertAdjacentHTML('beforeend', productBlockTemplate(i));
        }
        attachRemoveHandlers();
    }

    function attachRemoveHandlers() {
        container.querySelectorAll('.remove-product').forEach(btn => {
            btn.onclick = function () {
                const card = this.closest('.card');
                if (card) card.remove();
                renumberBlocks();
            };
        });
    }

    function renumberBlocks() {
        container.querySelectorAll('.card').forEach((card, idx) => {
            card.setAttribute('data-index', idx);
            const selects = card.querySelectorAll('select, input[name$="[quantity]"], input[name$="[weight]"]');
            selects.forEach(el => {
                if (el.name.includes('[product_id]')) el.name = `own_order_products[${idx}][product_id]`;
                if (el.name.includes('[weight_id]')) el.name = `own_order_products[${idx}][weight_id]`;
                if (el.name.includes('[quantity]')) el.name = `own_order_products[${idx}][quantity]`;
                if (el.name.includes('[weight]')) el.name = `own_order_products[${idx}][weight]`;
            });
        });
    }

    // Cuando cambie el select de cantidad
    productsCount.addEventListener('change', function () {
        const n = parseInt(this.value, 10) || 0;
        renderBlocks(n);
    });

    attachRemoveHandlers();
})();
</script>
