<?php

namespace App\Http\Controllers;

use App\Models\Toast;
use App\Models\OwnOrder;
use App\Models\MaquilaOrder;
use Illuminate\Http\Request;

class ToastController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ownOrders = OwnOrder::with(['costumer', 'user', 'toasts'])->orderByDesc('id')->get();
        $maquilaOrders = MaquilaOrder::with(['costumer', 'user', 'toasts'])->orderByDesc('id')->get();

        return view('tostiones.index', compact('ownOrders', 'maquilaOrders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ownOrderId = $request->input('own_order_id');
        $maquilaOrderId = $request->input('maquila_order_id');

        $ownOrderId = ($ownOrderId === '' || $ownOrderId === null) ? null : $ownOrderId;
        $maquilaOrderId = ($maquilaOrderId === '' || $maquilaOrderId === null) ? null : $maquilaOrderId;

        $validated = $request->validate([
            'start_weight' => 'required|numeric|min:0',
            'final_weight' => 'required|numeric|min:0',
            'decrease'     => 'required|numeric',
        ]);

        if (is_null($ownOrderId) && is_null($maquilaOrderId)) {
            return back()->withErrors(['order' => 'Debe seleccionar un pedido válido para registrar la tostión.'])->withInput();
        }

        $toast = new Toast();
        $toast->own_order_id = $ownOrderId;
        $toast->maquila_order_id = $maquilaOrderId;
        $toast->start_weight = (string) $validated['start_weight'];
        $toast->decrease = (string) $validated['decrease'];
        $toast->final_weight = (string) $validated['final_weight'];
        $toast->save();

        return redirect()->route('tostiones.index')->with('success', 'Registro de tostión guardado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Toast  $toast
     * @return \Illuminate\Http\Response
     */
    public function destroy(Toast $toast)
    {
        $toast->delete();
        return redirect()->route('tostiones.index')->with('success', 'Registro de tostión eliminado correctamente.');
    }
}
