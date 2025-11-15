<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Pedido Propio - CAFEMOLINA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .navbar-cafe { background-color: #5A3825; }
        .navbar-cafe .nav-link { color: #F8E7D3; }
        .navbar-brand { color: #F8E7D3 !important; }
        .cafe-section { background-color: #f5f1ed; border-left: 4px solid #5A3825; padding: 20px; margin-bottom: 30px; border-radius: 6px;}
        .cafe-section h3 { color: #5A3825; font-weight: bold; margin-bottom: 20px; }
        .form-label { color: #5A3825; font-weight: 600; }
        .btn-cafe { background-color: #5A3825; border-color: #5A3825; color: #F8E7D3; }
        .btn-cafe:hover { background-color: #7a5237; border-color: #7a5237; color: #ffffff; }
        .table-cafe thead { background-color: #5A3825; color: #F8E7D3; }
        .table-cafe tbody tr:hover { background-color: #f0e6d2; }
        .btn-action { margin: 2px; }
    </style>
</head>
<body>

@include('navbar')

<div class="container mt-4">

    <div class="cafe-section">
        <h3>📝 Crear Pedido Propio</h3>

        <form id="ownOrderForm" action="{{route("own-orders.store")}}" method="POST">
            @csrf 

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
                    <label class="form-label" for="entry_date">Fecha de entrada</label>
                    <input id="entry_date" name="entry_date" type="date" class="form-control" required>
                </div>
            </div>

            <div class="row g-3 mb-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label" for="urgent_select">¿Urgente?</label>
                    <select id="urgent_select" name="urgent_order" class="form-select" required>
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

                <div class="col-md-4">
                    <label class="form-label" for="products_count">Cantidad de productos a añadir</label>
                    <select id="products_count" class="form-select">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
            </div>

            <hr>

            <div id="productsContainer" class="mb-3"></div>

            <button type="submit" class="btn btn-cafe">Guardar Pedido</button>
            <a href="#" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    
</div>

@include('footer')


<script>
    (function () {
        const productsCount = document.getElementById('products_count');
        const container = document.getElementById('productsContainer');

        function productBlockTemplate(index) {
            return `
            <div class="card mb-3" data-index="${index}">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Producto</label>
                            <select name="own_order_products[${index}][product_id]" class="form-select" required>
                                <option value="">-- Seleccione producto --</option>
                                     @foreach($products as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                     @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Peso / Presentación</label>
                            <select name="own_order_products[${index}][weight_id]" class="form-select" required>
                                <option value="">-- Seleccione peso --</option>
                                     @foreach($weights as $w)
                                        <option value="{{ $w->id }}">{{ $w->presentation }}</option>
                                     @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Cantidad</label>
                            <input type="number" min="1" value="1" name="own_order_products[${index}][quantity]" class="form-control" required>
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm remove-product">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
            `;
        }

        // render N blocks
        function renderBlocks(n) {
            container.innerHTML = '';
            for (let i = 0; i < n; i++) {
                container.insertAdjacentHTML('beforeend', productBlockTemplate(i));
            }
            attachRemoveHandlers();
        }

        // attach remove handlers to dynamically created buttons
        function attachRemoveHandlers() {
            container.querySelectorAll('.remove-product').forEach(btn => {
                btn.onclick = function () {
                    const card = this.closest('.card');
                    if (card) card.remove();
                    // renumber names after removal
                    renumberBlocks();
                    // update the products_count select to actual number
                    const count = container.querySelectorAll('.card').length;
                    productsCount.value = count.toString();
                };
            });
        }

        // renumber input names so indices are continuous
        function renumberBlocks() {
            container.querySelectorAll('.card').forEach((card, idx) => {
                card.setAttribute('data-index', idx);
                const selects = card.querySelectorAll('select, input[name$="[quantity]"]');
                selects.forEach(el => {
                    if (el.name.includes('[product_id]')) el.name = `own_order_products[${idx}][product_id]`;
                    if (el.name.includes('[weight_id]')) el.name = `own_order_products[${idx}][weight_id]`;
                    if (el.name.includes('[quantity]')) el.name = `own_order_products[${idx}][quantity]`;
                });
            });
        }

        // when user changes the count select
        productsCount.addEventListener('change', function () {
            const n = parseInt(this.value, 10) || 0;
            renderBlocks(n);
        });

        // initial state: 0 blocks
        renderBlocks(0);
    })();
</script>

</body>
</html>