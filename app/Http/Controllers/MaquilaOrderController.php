<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\MaquilaOrder;
use App\Models\MaquilaMesh;
use App\Models\MaquilaService;
use App\Models\MaquilaPackage;
use App\Models\User;
use App\Models\Costumer;
use App\Models\Service;
use App\Models\Mesh;
use App\Models\Package;
use App\Models\Measure;

class MaquilaOrderController extends Controller
{
    /**
     * Display the form to create a maquila order.
     */
    public function index()
    {
        $users = User::orderBy('name')->get();
        $costumers = Costumer::orderBy('name')->get();
        $services = Service::orderBy('id')->get();
        $meshes = Mesh::orderBy('id')->get();
        $packages = Package::orderBy('id')->get();
        $measures = Measure::orderBy('id')->get();

        return view('maquila_order.index', compact(
            'users',
            'costumers',
            'services',
            'meshes',
            'packages',
            'measures'
        ));
    }

    /**
     * Store a newly created maquila order and its relations.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'costumer_id' => 'required|exists:costumers,id',
            'coffe_type' => 'nullable|string|max:255',
            'quality_type' => 'nullable|string|max:255',
            'toast_type' => 'nullable|string|max:255',
            'recieved_kilograms' => 'nullable|numeric',
            'green_density' => 'nullable|string|max:255',
            'green_humidity' => 'nullable|string|max:255',
            'tag' => 'nullable|string|max:255',
            'peel_stick' => 'nullable|in:yes,no',
            'printed_label' => 'nullable|in:yes,no',
            'urgent_order' => 'nullable|in:yes,no',
            'status' => 'nullable|string|max:100',
            'observations' => 'nullable|string',

            // arrays
            'maquila_services' => 'nullable|array',
            'maquila_services.*.service_id' => 'required_with:maquila_services|exists:services,id',
            'maquila_services.*.selection' => 'nullable|in:yes,no',

            'maquila_meshes' => 'nullable|array',
            'maquila_meshes.*.meshe_id' => 'required_with:maquila_meshes|exists:meshes,id',
            'maquila_meshes.*.weight' => 'nullable|numeric|min:0',

            'maquila_packages' => 'nullable|array',
            'maquila_packages.*.package_id' => 'required_with:maquila_packages|exists:packages,id',
            'maquila_packages.*.measure_id' => 'required_with:maquila_packages|exists:measures,id',
            'maquila_packages.*.kilograms' => 'required_with:maquila_packages|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated, $request, &$maquilaOrder) {
            // create maquila order
            $maquilaOrder = new MaquilaOrder();
            $maquilaOrder->user_id = $validated['user_id'];
            $maquilaOrder->costumer_id = $validated['costumer_id'];
            $maquilaOrder->coffe_type = $validated['coffe_type'] ?? null;
            $maquilaOrder->quality_type = $validated['quality_type'] ?? null;
            $maquilaOrder->toast_type = $validated['toast_type'] ?? null;
            $maquilaOrder->recieved_kilograms = $validated['recieved_kilograms'] ?? null;
            $maquilaOrder->green_density = $validated['green_density'] ?? null;
            $maquilaOrder->green_humidity = $validated['green_humidity'] ?? null;
            $maquilaOrder->tag = $validated['tag'] ?? null;
            $maquilaOrder->peel_stick = $validated['peel_stick'] ?? null;
            $maquilaOrder->printed_label = $validated['printed_label'] ?? null;
            $maquilaOrder->urgent_order = $validated['urgent_order'] ?? null;
            $maquilaOrder->status = 'received';
            $maquilaOrder->observations = $validated['observations'] ?? null;
            $maquilaOrder->save();

            // maquila services - create all services regardless of yes/no selection
            $services = $request->input('maquila_services', []);
            foreach ($services as $s) {
                if (empty($s['service_id'])) continue;

                $ms = new MaquilaService();
                $ms->maquila_order_id = $maquilaOrder->id;
                $ms->service_id = $s['service_id'];
                $ms->selection = $s['selection'] ?? 'no';
                if (isset($s['quantity'])) $ms->quantity = $s['quantity'];
                $ms->save();
            }

            // maquila meshes - create entry for each mesh with weight > 0
            $meshes = $request->input('maquila_meshes', []);
            foreach ($meshes as $m) {
                if (empty($m['meshe_id'])) continue;
                $weight = isset($m['weight']) ? (float)$m['weight'] : 0;
                if ($weight <= 0) continue;

                $mm = new MaquilaMesh();
                $mm->maquila_order_id = $maquilaOrder->id;
                $mm->meshe_id = $m['meshe_id'];
                $mm->weight = $weight;
                $mm->save();
            }

            // maquila packages
            $packages = $request->input('maquila_packages', []);
            foreach ($packages as $p) {
                if (empty($p['package_id'])) continue;
                $mp = new MaquilaPackage();
                $mp->maquila_order_id = $maquilaOrder->id;
                $mp->package_id = $p['package_id'];
                $mp->measure_id = $p['measure_id'] ?? null;
                $mp->kilograms = isset($p['kilograms']) ? $p['kilograms'] : null;
                $mp->save();
            }

            // create maquila_order_states: one record per existing state, all with selected = 'no'
            if (Schema::hasTable('states') && Schema::hasTable('maquila_order_states')) {
                $stateIds = DB::table('states')->pluck('id');
                if ($stateIds->isNotEmpty()) {
                    $now = now();
                    $inserts = [];
                    $minId = 1;
                    foreach ($stateIds as $stateId) {
                        $inserts[] = [
                            'maquila_order_id' => $maquilaOrder->id,
                            'state_id' => $stateId,
                            'selected' => $stateId == $minId ? 'yes' : 'no',
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }
                    DB::table('maquila_order_states')->insert($inserts);
                }
            }
        });

        return redirect()->route('maquila-orders.index')->with('success', 'Pedido maquila creado correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MaquilaOrder  $maquilaOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(MaquilaOrder $maquilaOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaquilaOrder  $maquilaOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaquilaOrder $maquilaOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaquilaOrder  $maquilaOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaquilaOrder $maquilaOrder)
    {
        //
    }
}
