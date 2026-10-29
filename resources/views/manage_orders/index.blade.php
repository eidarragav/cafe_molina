@include('navbar')

<div class="container-fluid px-4 my-4">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold mb-0" style="color: var(--cafe-olive);">
                <i class="fas fa-tasks me-2"></i> Tablero de Gestión de Pedidos
            </h2>
            <p class="text-muted small mb-0">Control de producción en planta: seguimiento de lotes por etapas y estados</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('maquila-orders.index') }}" class="btn btn-sm btn-olive">
                <i class="fas fa-plus me-1"></i> Nueva Maquila
            </a>
            <a href="{{ route('own-orders.index') }}" class="btn btn-sm btn-cafe">
                <i class="fas fa-plus me-1"></i> Nuevo Pedido Propio
            </a>
        </div>
    </div>

    <!-- Area Filter Buttons -->
    <div class="d-flex gap-2 mb-4 flex-wrap">
        <a href="{{ route('manage.orders.index') }}"
           class="btn btn-sm {{ $selectedArea === 0 ? 'btn-olive' : 'btn-outline-secondary' }}">
            <i class="fas fa-th-large me-1"></i> Todas las Áreas (Vista General)
        </a>

        <a href="{{ route('manage.orders.index', ['area' => 1]) }}"
           class="btn btn-sm {{ $selectedArea === 1 ? 'btn-warning text-dark' : 'btn-outline-secondary' }}">
            <i class="fas fa-cogs me-1"></i> 1. Trillado & Mallas ({{ $area1->count() }})
        </a>

        <a href="{{ route('manage.orders.index', ['area' => 2]) }}"
           class="btn btn-sm {{ $selectedArea === 2 ? 'btn-danger' : 'btn-outline-secondary' }}">
            <i class="fas fa-fire me-1"></i> 2. Tostión ({{ $area2->count() }})
        </a>

        <a href="{{ route('manage.orders.index', ['area' => 3]) }}"
           class="btn btn-sm {{ $selectedArea === 3 ? 'btn-primary' : 'btn-outline-secondary' }}">
            <i class="fas fa-box me-1"></i> 3. Empaque & Molienda ({{ $area3->count() }})
        </a>

        <a href="{{ route('manage.orders.index', ['area' => 4]) }}"
           class="btn btn-sm {{ $selectedArea === 4 ? 'btn-success' : 'btn-outline-secondary' }}">
            <i class="fas fa-check-double me-1"></i> 4. Terminados ({{ $area4->count() }})
        </a>
    </div>

    <!-- Areas Columns -->
    <div class="row g-3">
        @if($selectedArea === 0)
            <div class="col-xl-3 col-md-6">
                @include('manage_orders.partials.area', ['title' => '1. Trillado & Mallas', 'badgeColor' => 'warning', 'items' => $area1, 'allStates' => $allStates])
            </div> 
            <div class="col-xl-3 col-md-6">
                @include('manage_orders.partials.area', ['title' => '2. Tostión', 'badgeColor' => 'danger', 'items' => $area2, 'allStates' => $allStates])
            </div>
            <div class="col-xl-3 col-md-6">
                @include('manage_orders.partials.area', ['title' => '3. Empaque & Molienda', 'badgeColor' => 'primary', 'items' => $area3, 'allStates' => $allStates])
            </div>
            <div class="col-xl-3 col-md-6">
                @include('manage_orders.partials.area', ['title' => '4. Terminados para Despacho', 'badgeColor' => 'success', 'items' => $area4, 'allStates' => $allStates])
            </div>
        @else
            <div class="col-12">
                @if($selectedArea === 1)
                    @include('manage_orders.partials.area', ['title' => 'Área 1: Trillado & Clasificación de Mallas', 'badgeColor' => 'warning', 'items' => $area1, 'allStates' => $allStates])
                @elseif($selectedArea === 2)
                    @include('manage_orders.partials.area', ['title' => 'Área 2: Tostión de Café', 'badgeColor' => 'danger', 'items' => $area2, 'allStates' => $allStates])
                @elseif($selectedArea === 3)
                    @include('manage_orders.partials.area', ['title' => 'Área 3: Molienda y Empaquetado', 'badgeColor' => 'primary', 'items' => $area3, 'allStates' => $allStates])
                @elseif($selectedArea === 4)
                    @include('manage_orders.partials.area', ['title' => 'Área 4: Lotes Terminados / Listos para Entrega', 'badgeColor' => 'success', 'items' => $area4, 'allStates' => $allStates])
                @endif
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

    document.querySelectorAll('.states-checklist').forEach(container => {
        container.addEventListener('click', async (e) => {
            const target = e.target;
            if (!target.classList.contains('state-checklist-item')) return;

            const orderId = container.getAttribute('data-order-id');
            const orderType = container.getAttribute('data-order-type');
            const stateId = target.getAttribute('data-state-id');
            const currentlySelected = target.getAttribute('data-selected') === '1';

            if (currentlySelected) return;

            container.style.pointerEvents = 'none';

            try {
                const endpoint = orderType === 'own'
                    ? `/own-orders/${orderId}/update-selected-state`
                    : `/maquila-orders/${orderId}/update-selected-state`;

                const response = await fetch(endpoint, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({ state_id: stateId, selected: 'yes' }),
                });

                if (!response.ok) {
                    const errorBody = await response.text();
                    throw new Error(`Error en servidor (${response.status}): ${errorBody}`);
                }

                target.style.backgroundColor = 'var(--cafe-accent)';
                target.style.color = '#fff';
                target.setAttribute('data-selected', '1');

                // Reload to refresh the order across areas if moved
                location.reload();

            } catch (error) {
                alert('No se pudo actualizar el estado: ' + error.message);
            } finally {
                container.style.pointerEvents = '';
            }
        });
    });
});
</script>

@include('footer')
