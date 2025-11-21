@include('navbar')

<div class="container my-4">
    <div class="d-flex gap-2 mb-3">
        <a href="{{ route('manage.orders.index') }}" class="btn {{ $selectedArea === 0 ? 'btn-cafe' : 'btn-outline-secondary' }}">Todos</a>
        <a href="{{ route('manage.orders.index', ['area' => 1]) }}" class="btn {{ $selectedArea === 1 ? 'btn-cafe' : 'btn-outline-secondary' }}">Área 1 (1–4 / received)</a>
        <a href="{{ route('manage.orders.index', ['area' => 2]) }}" class="btn {{ $selectedArea === 2 ? 'btn-cafe' : 'btn-outline-secondary' }}">Área 2 (4–5)</a>
        <a href="{{ route('manage.orders.index', ['area' => 3]) }}" class="btn {{ $selectedArea === 3 ? 'btn-cafe' : 'btn-outline-secondary' }}">Área 3 (6–10)</a>
    </div>

    <div class="row g-3">
        @if($selectedArea === 0 || $selectedArea === 1)
            <div class="col-lg-4">
                {{-- Area 1 card and loop (same markup you already have) --}}
                @include('manage_orders.partials.area', ['title' => 'Área 1 — Estados 1–4', 'items' => $area1])
            </div>
        @endif

        @if($selectedArea === 0 || $selectedArea === 2)
            <div class="col-lg-4">
                {{-- Area 2 --}}
                @include('manage_orders.partials.area', ['title' => 'Área 2 — Estados 4–5', 'items' => $area2])
            </div>
        @endif

        @if($selectedArea === 0 || $selectedArea === 3)
            <div class="col-lg-4">
                {{-- Area 3 --}}
                @include('manage_orders.partials.area', ['title' => 'Área 3 — Estados 6–10', 'items' => $area3])
            </div>
        @endif
    </div>
</div>

@include('footer')
</body>
</html>