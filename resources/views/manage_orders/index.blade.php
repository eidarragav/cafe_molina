<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
</head>
<body>
@include('navbar')

<div class="container my-4">
    <div class="d-flex gap-2 mb-3">
        <style>
            .btn-olive {
                background-color: #556B2F;
                color: white;
                border: 1px solid #556B2F;
                transition: background-color 0.3s, color 0.3s;
            }
            .btn-olive:hover, .btn-olive:focus {
                background-color: #8DB600;
                color: white;
                border-color: #8DB600;
                
            }
            .btn-beige {
                background-color: #d8c3a5;
                color: #4b3f2f;
                border: 1px solid #d8c3a5;
            }
            .btn-beige:hover, .btn-beige:focus {
                background-color: #e4d2b8;
                color: #4b3f2f;
                border-color: #e4d2b8;
            }

            .btn-cafe {
                background-color: #6f4e37;
                color: white;
                border: 1px solid #6f4e37;
            }
            .btn-cafe:hover, .btn-cafe:focus {
                background-color: #8b5e45;
                color: white;
                border-color: #8b5e45;
            }

            .btn-azul {
                background-color: #1b2a49;
                color: white;
                border: 1px solid #1b2a49;
            }
            .btn-azul:hover, .btn-azul:focus {
                background-color: #24355c;
                color: white;
                border-color: #24355c;
            }

            .btn-red {
                background-color: #FF0000;
                color: white;
                border: 1px solid #FF0000;
            }
            .btn-red:hover, .btn-red:focus {
                background-color: #FF0000;
                color: white;
                border-color: #FF0000;
            }
        </style>
        <a href="{{ route('manage.orders.index') }}"
        class="btn {{ $selectedArea === 0 ? 'btn-olive' : 'btn-outline-secondary' }}">
            Todos
        </a>

        <a href="{{ route('manage.orders.index', ['area' => 1]) }}"
        class="btn {{ $selectedArea === 1 ? 'btn-beige' : 'btn-outline-secondary' }}">
            Trillado
        </a>

        <a href="{{ route('manage.orders.index', ['area' => 2]) }}"
        class="btn {{ $selectedArea === 2 ? 'btn-cafe' : 'btn-outline-secondary' }}">
            Tostión
        </a>

        <a href="{{ route('manage.orders.index', ['area' => 3]) }}"
        class="btn {{ $selectedArea === 3 ? 'btn-azul' : 'btn-outline-secondary' }}">
            Empaque
        </a>

        <a href="{{ route('manage.orders.index', ['area' => 4]) }}"
        class="btn {{ $selectedArea === 4 ? 'btn-red' : 'btn-outline-secondary' }}">
            Terminados
        </a>
    </div>

    <div class="row g-3">
        @if($selectedArea ===0)
            <div class="col-lg-3">
                    {{-- Area 1 card and loop (same markup you already have) --}}
                    @include('manage_orders.partials.area', ['title' => 'Trillado', 'items' => $area1])
            </div> 
            <div class="col-lg-3">
                {{-- Area 2 --}}
                @include('manage_orders.partials.area', ['title' => 'Tostion', 'items' => $area2])
            </div>
            <div class="col-lg-3">
                {{-- Area 3 --}}
                @include('manage_orders.partials.area', ['title' => 'Empaque', 'items' => $area3])
            </div>
            <div class="col-lg-3">
                {{-- Area 3 --}}
                @include('manage_orders.partials.area', ['title' => 'Terminado', 'items' => $area4])
            </div>
        @endif

        @if( $selectedArea === 1)
            <div class="col-lg-12">
                {{-- Area 1 card and loop (same markup you already have) --}}
                @include('manage_orders.partials.area', ['title' => 'Trillado', 'items' => $area1])
            </div>
        @endif

        @if($selectedArea === 2)
            <div class="col-lg-12">
                {{-- Area 2 --}}
                @include('manage_orders.partials.area', ['title' => 'Tostion', 'items' => $area2])
            </div>
        @endif

        @if($selectedArea === 3)
            <div class="col-lg-12">
                {{-- Area 3 --}}
                @include('manage_orders.partials.area', ['title' => 'Empaque', 'items' => $area3])
            </div>
        @endif

        @if($selectedArea === 4)
            <div class="col-lg-12">
                {{-- Area 3 --}}
                @include('manage_orders.partials.area', ['title' => 'Terminado', 'items' => $area4])
            </div>
        @endif
    </div>
</div>

@include('footer')

<script>
document.addEventListener('DOMContentLoaded', () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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
                    throw new Error(`Network response was not OK. Status: ${response.status}, Body: ${errorBody}`);
                }

                target.style.backgroundColor = '#0d6efd';
                target.style.color = '#fff';
                target.setAttribute('data-selected', '1');

                // Reload page after update to refresh area view
                location.reload();

            } catch (error) {
                alert('Error updating state selection: ' + error);
            } finally {
                container.style.pointerEvents = '';
            }
        });
    });
});
</script>
</body>
</html>
