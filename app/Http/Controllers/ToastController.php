<?php

namespace App\Http\Controllers;

use App\Models\Toast;
use App\Models\OwnOrder;
use App\Models\MaquilaOrder;
use Illuminate\Http\Request;

class ToastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ownOrders = OwnOrder::with(['costumer', 'user', 'toasts'])->get();
        $maquilaOrders = MaquilaOrder::with(['costumer', 'user', 'toasts'])->get();

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
        // Convert empty strings to null for foreign keys
        $ownOrderId = $request->input('own_order_id');
        $maquilaOrderId = $request->input('maquila_order_id');

        $ownOrderId = ($ownOrderId === '' || $ownOrderId === null) ? null : $ownOrderId;
        $maquilaOrderId = ($maquilaOrderId === '' || $maquilaOrderId === null) ? null : $maquilaOrderId;

        // Validate inputs including FK presence
        $validated = $request->validate([
            'start_weight' => 'required|string|max:255',
            'decrease' => 'required|string|max:255',
            'final_weight' => 'required|string|max:255',
            
        ]);

        // Check at least one FK specified
        if (is_null($ownOrderId) && is_null($maquilaOrderId)) {
            return back()->withErrors(['order' => 'Debe seleccionar un pedido válido para crear un tostion.'])->withInput();
        }

        $toast = new \App\Models\Toast();
        $toast->own_order_id = $ownOrderId;
        $toast->maquila_order_id = $maquilaOrderId;
        $toast->start_weight = $validated['start_weight'];
        $toast->decrease = $validated['decrease'];
        $toast->final_weight = $validated['final_weight'];
        $toast->save();

        return redirect()->route('tostiones.index')->with('success', 'Tostion creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Toast  $toast
     * @return \Illuminate\Http\Response
     */
    public function show(Toast $toast)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Toast  $toast
     * @return \Illuminate\Http\Response
     */
    public function edit(Toast $toast)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Toast  $toast
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Toast $toast)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Toast  $toast
     * @return \Illuminate\Http\Response
     */
    public function destroy(Toast $toast)
    {
        //
    }
}
