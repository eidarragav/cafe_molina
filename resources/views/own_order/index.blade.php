

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
                        <option value="{{Auth::user()->id}}" selected>{{ Auth::user()->name }}</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="costumer_id">Cliente</label>
                    <div class="input-group">
                        <select id="costumer_id" name="costumer_id" class="form-select" required>
                            <option value="">-- Seleccione cliente --</option>
                                 @foreach($costumers as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                 @endforeach
                        </select>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#newCostumerModal">
                            <i class="fas fa-plus"></i> Nuevo
                        </button>
                    </div>
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

<!-- New Costumer Modal -->
<div class="modal fade" id="newCostumerModal" tabindex="-1" aria-labelledby="newCostumerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="newCostumerForm" method="POST" action="{{ route('costumers.store') }}">
                @csrf
                <div class="modal-header" style="background:#5A3825; color:#F8E7D3">
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

    // New Costumer Modal Handler
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
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const data = new FormData(form);

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: data
                });

                const json = await res.json().catch(() => null);

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

                // Success - costumer created
                const created = json && json.costumer ? json.costumer : json;
                if (created && created.id) {
                    // add to select and select it
                    const optionText = created.name + (created.farm ? ' — ' + created.farm : '');
                    const newOpt = new Option(optionText, created.id, true, true);
                    costumerSelect.add(newOpt);
                    costumerSelect.value = created.id;
                }

                // close modal - hide backdrop manually
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) {
                    modal.hide();
                }
                
                // Remove modal backdrop if stuck
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                document.body.style.overflow = '';
                document.body.classList.remove('modal-open');

                // clear form
                form.reset();

            } catch (err) {
                console.error('Error:', err);
                errorsBox.innerHTML = 'No se pudo conectar con el servidor.';
                errorsBox.classList.remove('d-none');
            }
        });
    })();
</script>

</body>
</html>