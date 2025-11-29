@include('navbar')
    <style>


    h2, h4, h6 {
        color: #556B2F;
        font-weight: 700;
    }

    .container {
        background-color: #FAFAF7; 
        padding: 20px;
        border-radius: 12px;
    }


    .list-group-item {
        background-color: #ffffff;
        border-radius: 12px !important;
        margin-bottom: 12px;
        border: 1px solid #dfe4d4;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        padding: 18px;
        transition: transform 0.2s ease;
    }

    .list-group-item:hover {
        transform: translateY(-2px);
    }

    .btn-primary {
        background-color: #8DB600;   
        border-color: #7da300;
        font-weight: 600;
    }
    .btn-primary:hover {
        background-color: #7da300;
        border-color: #6c9200;
    }

    .btn-success {
        background-color: #556B2F;
        border-color: #556B2F;
        font-weight: 600;
    }
    .btn-success:hover {
        background-color: #445726;
        border-color: #445726;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #c7d1b5;
    }
    .form-label {
        font-weight: 600;
        color: #556B2F;
    }


    .list-group .list-group-item {
        background-color: #F7F9F4;
        border-left: 4px solid #8DB600;
    }


    .fa-fire {
        color: #8DB600;
    }

    .mt-3, .mb-4, .mt-4 {
        margin-top: 18px !important;
        margin-bottom: 18px !important;
    }

    @media (max-width: 768px) {
        .list-group-item {
            padding: 15px;
        }
    }
    </style>
<div class="container my-4">


    <h2 class="mb-4">Tostiones</h2>


    <h4 class="mt-4">Pedidos Propios</h4>

    @if($ownOrders->isEmpty())
        <p>No hay pedidos propios.</p>
    @else
        <div class="list-group mb-4">

            @foreach($ownOrders as $order)
                <div class="list-group-item">

                    {{-- HEADER --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Pedido ID:</strong> {{ $order->id }} <br>
                            <strong>Cliente:</strong> {{ $order->costumer->name ?? 'N/A' }} <br>
                            <strong>Usuario:</strong> {{ $order->user->name ?? 'N/A' }}
                        </div>

                        <button class="btn btn-sm btn-primary"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#toastFormOwn{{ $order->id }}">
                            Añadir Tostión
                        </button>
                    </div>

    
                    <div class="collapse mt-3" id="toastFormOwn{{ $order->id }}">
                        <form action="{{ route('toasts.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="own_order_id" value="{{ $order->id }}">

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Peso Inicial</label>
                                    <input id='startW' type="number" step="0.01" name="start_weight" class="form-control" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Peso final</label>
                                    <input id= 'finalW' type="number" onchange="merma()" step="0.01" name="final_weight" class="form-control" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Merma</label>
                                    <input  id ='mermad' type="number" step="0.01" name="decrease" class="form-control" required>
                                </div>

                                

                                <script>
                                    function merma(){ 
                                        console.log("Hola");

                                        const startW = parseFloat(document.getElementById("startW").value);
                                        const finalW = parseFloat(document.getElementById("finalW").value);

                                        const mermaInput = document.getElementById("mermad");

                                        mermaInput.value = startW - finalW;
                                    }
                                </script>
                            </div>

                            <button type="submit" class="btn btn-success mt-3">Guardar Tostión</button>
                        </form>
                    </div>

                    @if($order->toasts->count())
                        <div class="mt-3">
                            <h6><i class="fas fa-fire"></i> Tostiones Registradas</h6>

                            <ul class="list-group">
                                @foreach($order->toasts as $toast)
                                    <li class="list-group-item">
                                        <strong>Peso inicial:</strong> {{ $toast->start_weight }} kg —
                                        <strong>Peso final:</strong> {{ $toast->final_weight }} kg —
                                        <strong>Merma:</strong> {{ $toast->decrease }} kg —
                                        <strong>Fecha:</strong> {{ $toast->created_at->format('Y-m-d H:i') }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            @endforeach

        </div>
    @endif



    <h4 class="mt-4">Pedidos de Maquila</h4>

    @if($maquilaOrders->isEmpty())
        <p>No hay pedidos de maquila.</p>
    @else
        <div class="list-group mb-4">

            @foreach($maquilaOrders as $order)
                <div class="list-group-item">

                    {{-- HEADER --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Pedido ID:</strong> {{ $order->id }} <br>
                            <strong>Cliente:</strong> {{ $order->costumer->name ?? 'N/A' }} <br>
                            <strong>Usuario:</strong> {{ $order->user->name ?? 'N/A' }}
                        </div>

                        <button class="btn btn-sm btn-primary"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#toastFormMaq{{ $order->id }}">
                            Añadir Tostión
                        </button>
                    </div>

                    {{-- FORMULARIO --}}
                    <div class="collapse mt-3" id="toastFormMaq{{ $order->id }}">
                        <form action="{{ route('toasts.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="maquila_order_id" value="{{ $order->id }}">

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Peso Inicial</label>
                                    <input type="number" step="0.01" name="start_weight" class="form-control" required>
                                </div>

                                
                                <div class="col-md-4">
                                    <label class="form-label">Merma</label>
                                    <input onchange="finalWeight()" type="number" step="0.01" name="decrease" class="form-control" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Peso final</label>
                                    <input type="number" step="0.01" name="final_weight" class="form-control" required>
                                </div>

                                <script>
                                    function finalWeight() {
                                        var startWeight = parseFloat(document.querySelector('input[name="start_weight"]').value) || 0;
                                        var decrease = parseFloat(document.querySelector('input[name="decrease"]').value) || 0;
                                        var finalWeight = startWeight - decrease;
                                        document.querySelector('input[name="final_weight"]').value = finalWeight.toFixed(2);
                                    }
                                </script>

                            </div>

                            <button type="submit" class="btn btn-success mt-3">Guardar Tostión</button>
                        </form>
                    </div>

                    {{-- TOSTIONES EXISTENTES --}}
                    @if($order->toasts->count())
                        <div class="mt-3">
                            <h6><i class="fas fa-fire"></i> Tostiones Registradas</h6>

                            <ul class="list-group">
                                @foreach($order->toasts as $toast)
                                    <li class="list-group-item">
                                        <strong>Peso inicial:</strong> {{ $toast->start_weight }} kg —
                                        <strong>Merma:</strong> {{ $toast->decrease }} kg —
                                        <strong>Peso final:</strong> {{ $toast->final_weight }} kg —
                                        <strong>Fecha:</strong> {{ $toast->created_at->format('Y-m-d H:i') }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            @endforeach

        </div>
    @endif
</div>

@include('footer')