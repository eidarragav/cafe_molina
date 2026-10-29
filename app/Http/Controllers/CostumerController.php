<?php

namespace App\Http\Controllers;

use App\Models\Costumer;
use Illuminate\Http\Request;

class CostumerController extends Controller
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
        $costumers = Costumer::withCount(['own_orders', 'maquila_orders'])
            ->orderBy('name')
            ->get();

        return view('costumers.index', compact('costumers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('costumers.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'cedula' => 'required|string|max:255|unique:costumers,cedula',
            'phone'  => 'required|string|max:255',
            'farm'   => 'required|string|max:255',
        ]);

        $costumer = Costumer::create($validated);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'costumer' => $costumer,
                'message'  => 'Cliente registrado correctamente.'
            ], 201);
        }

        return redirect()->route('costumers.index')->with('success', 'Cliente registrado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Costumer  $costumer
     * @return \Illuminate\Http\Response
     */
    public function show(Costumer $costumer)
    {
        $costumer->load(['maquila_orders', 'own_orders']);
        return view('costumers.show', compact('costumer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Costumer  $costumer
     * @return \Illuminate\Http\Response
     */
    public function edit(Costumer $costumer)
    {
        return redirect()->route('costumers.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Costumer  $costumer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Costumer $costumer)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'cedula' => 'required|string|max:255|unique:costumers,cedula,' . $costumer->id,
            'phone'  => 'required|string|max:255',
            'farm'   => 'required|string|max:255',
        ]);

        $costumer->update($validated);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['costumer' => $costumer, 'message' => 'Cliente actualizado correctamente.'], 200);
        }

        return redirect()->route('costumers.index')->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Costumer  $costumer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Costumer $costumer)
    {
        $costumer->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['message' => 'Cliente eliminado correctamente.'], 200);
        }

        return redirect()->route('costumers.index')->with('success', 'Cliente eliminado correctamente.');
    }
}
