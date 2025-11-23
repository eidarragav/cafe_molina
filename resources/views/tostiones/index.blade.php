@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h2>Tostiones</h2>

    <h4>Pedidos Propios (Own Orders)</h4>
    @if($ownOrders->isEmpty())
        <p>No hay pedidos propios.</p>
    @else
        <div class="list-group mb-4">
            @foreach($ownOrders as $order)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Pedido ID:</strong> {{ $order->id }}
                            <br>
                            <strong>Cliente:</strong> {{ $order->costumer->name ?? 'N/A' }}
                            <br>
                            <strong>Usuario:</strong> {{ $order->user->name ?? 'N/A' }}
                        </div>
                        <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#toastFormOwn{{ $order->id }}" aria-expanded="false" aria-controls="toastFormOwn{{ $order->id }}">
                            Añadir Tostion
                        </button>
                    </div>
                    <div class="collapse mt-3" id="toastFormOwn{{ $order->id }}">
                        <form action="{{ route('toasts.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="own_order_id" value="{{ $order->id ?? null }}">
                            <div class="mb-3">
                                <label for="start_weight_own_{{ $order->id }}" class="form-label">Peso Inicial</label>
                                <input type="text" class="form-control" id="start_weight_own_{{ $order->id }}" name="start_weight" required>
                            </div>
                            <div class="mb-3">
                                <label for="decrease_own_{{ $order->id }}" class="form-label">Disminución</label>
                                <input type="text" class="form-control" id="decrease_own_{{ $order->id }}" name="decrease" required>
                            </div>
                            <button type="submit" class="btn btn-success">Guardar Tostion</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <h4>Pedidos Maquila (Maquila Orders)</h4>
    @if($maquilaOrders->isEmpty())
        <p>No hay pedidos maquilas.</p>
    @else
        <div class="list-group">
            @foreach($maquilaOrders as $order)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Pedido ID:</strong> {{ $order->id }}
                            <br>
                            <strong>Cliente:</strong> {{ $order->costumer->name ?? 'N/A' }}
                            <br>
                            <strong>Usuario:</strong> {{ $order->user->name ?? 'N/A' }}
                        </div>
                        <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#toastFormMaq{{ $order->id }}" aria-expanded="false" aria-controls="toastFormMaq{{ $order->id }}">
                            Añadir Tostion
                        </button>
                    </div>
                    <div class="collapse mt-3" id="toastFormMaq{{ $order->id }}">
                        <form action="{{ route('toasts.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="maquila_order_id" value="{{ $order->id ?? null }}">
                            <div class="mb-3">
                                <label for="start_weight_maq_{{ $order->id }}" class="form-label">Peso Inicial</label>
                                <input type="text" class="form-control" id="start_weight_maq_{{ $order->id }}" name="start_weight" required>
                            </div>
                            <div class="mb-3">
                                <label for="decrease_maq_{{ $order->id }}" class="form-label">Disminución</label>
                                <input type="text" class="form-control" id="decrease_maq_{{ $order->id }}" name="decrease" required>
                            </div>
                            <button type="submit" class="btn btn-success">Guardar Tostion</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
