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
use Carbon\Carbon;
use App\Models\Package;
use App\Models\Measure;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $packages = Package::orderBy('package_type')->get();

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
            'presentation' => 'nullable|string',
            'management_criteria' => 'nullable|string',

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
            $maquilaOrder->entry_date = $request->input('entry_date');
            $maquilaOrder->green_density = $validated['green_density'] ?? null;
            $maquilaOrder->green_humidity = $validated['green_humidity'] ?? null;
            $maquilaOrder->tag = $validated['tag'] ?? null;
            $maquilaOrder->peel_stick = $validated['peel_stick'] ?? null;
            $maquilaOrder->printed_label = $validated['printed_label'] ?? null;
            $maquilaOrder->urgent_order = $validated['urgent_order'] ?? null;
            $maquilaOrder->status = 'received';
            $maquilaOrder->observations = $validated['observations'] ?? null;
            $maquilaOrder->net_weight = $request->input('net_weight', null);
            $maquilaOrder->packaging_type = $request->input('packaging_type', null);
            $maquilaOrder->packaging_quantity = $request->input('packaging_quantity');
            $maquilaOrder->management_criteria = $request->input('management_criteria');

            $maquilaOrder->save();

            $proccessingDaysTotal = MaquilaOrder::whereDoesntHave('maquila_order_states', function ($q) {
                $q->where('id', 11)
                ->where('selected', 'yes');
            })
            ->get()
            ->sum(function ($o) {
                if (!$o->departure_date || !$o->entry_date) return 1;

                return \Carbon\Carbon::parse($o->departure_date)
                    ->diffInDays(\Carbon\Carbon::parse($o->entry_date));
            });

            $entry = Carbon::parse($maquilaOrder->entry_date);

            $totalWeight = $request->input('net_weight');
            $calculateDays = 1 + (1 + 525/$totalWeight + 225 / $totalWeight  + 500/$totalWeight) + $proccessingDaysTotal;
            

            $maquilaOrder->departure_date = $entry->copy()->addDays($calculateDays);
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

            if ($request->has('packages')) {
                foreach ($request->packages as $pkg) {

                    if (empty($pkg['type']) || empty($pkg['mesh']) || empty($pkg['kilograms'])) {
                        continue;
                    }
                    
                    $package = Package::where('package_type', $pkg['type'])->first();

   
                    if (!$package) {
                        continue;
                    }

                    
                    // Crear maquila_packages
                    MaquilaPackage::create([
                        'maquila_order_id' => $maquilaOrder->id,
                        'package_id' => $package->id,
                        'mesh'       => $pkg['mesh'],
                        'kilograms'      => $pkg['kilograms'],
                        'presentation'  => $pkg['presentation']

                    ]);
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
    $costumers = Costumer::all();
    $services = Service::all();
    $meshes = Mesh::all();
    $packages = Package::all();

    return view('maquila_order.edit', compact(
        'maquilaOrder', 'costumers', 'services', 'meshes', 'packages'
    ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaquilaOrder  $maquilaOrder
     * @return \Illuminate\Http\Response
     */
        public function update(Request $request, $id)
        {
            $maquilaOrder = MaquilaOrder::where('id', $id)->first();
            $maquilaOrder->entry_date = $request->entry_date;
            $maquilaOrder->departure_date = $request->departure_date;
            $maquilaOrder->urgent_order = $request->urgent_order;
            $maquilaOrder->management_criteria = $request->management_criteria;
            $maquilaOrder->save();


            $totalWeight = $maquilaOrder->net_weight;
            if(!$request->input('departure_date')){
                $proccessingDaysTotal = MaquilaOrder::whereDoesntHave('maquila_order_states', function ($q) {
                $q->where('id', 11)->where('selected', 'yes');
                })->get()->sum(function ($o) {
                    if (!$o->departure_date || !$o->entry_date) return 1;
                    return \Carbon\Carbon::parse($o->departure_date)
                        ->diffInDays(\Carbon\Carbon::parse($o->entry_date));
                });

                $entry = Carbon::parse($maquilaOrder->entry_date);
                $calculateDays = 1 + (1 + 225 / max($totalWeight,1) + 1 + 0.5) + $proccessingDaysTotal;
                $maquilaOrder->departure_date = $entry->copy()->addDays($calculateDays);
                $maquilaOrder->save();
            }
        return redirect()->route('manage.orders.index')->with('success', 'Pedido maquila actualizado correctamente.');
        }

    /**
     * Update selected state for a MaquilaOrder.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id MaquilaOrder ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSelectedState(Request $request, $id)
    {
        $request->validate([
            'state_id' => 'required|integer|exists:states,id',
            'selected' => 'required|string|in:yes,no',
        ]);

        $maquilaOrder = MaquilaOrder::findOrFail($id);

        $stateId = $request->input('state_id');
        $selected = $request->input('selected');

        // Update the selected state record
        $updated = \DB::table('maquila_order_states')
            ->where('maquila_order_id', $maquilaOrder->id)
            ->where('state_id', $stateId)
            ->update(['selected' => $selected, 'updated_at' => now()]);

        if ($updated) {
            return response()->json(['message' => 'Selected state updated successfully']);
        } else {
            // Log or treat as success to avoid frontend error alert
            // \Log::warning('Selected state update affected zero rows', ['maquila_order_id' => $maquilaOrder->id, 'state_id' => $stateId]);
            return response()->json(['message' => 'Selected state update processed (no rows affected)']);
        }
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

    public function show($id)
    {
        $order = MaquilaOrder::with([
            'user',
            'costumer',
            'maquila_meshes',
            'maquila_packages',
            'maquila_services',
            'toasts',
            'maquila_order_states'
        ])->findOrFail($id);

        return view('maquila_order.show', compact('order'));
    }



    public function maquila_pdf($id)
    {
        $order = MaquilaOrder::with([
            'user',
            'costumer',
            'maquila_meshes',
            'maquila_packages',
            'maquila_services',
            'toasts',
            'maquila_order_states'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('maquila_order.pdf.show', compact('order'));

        return $pdf->stream('reporte.pdf');
    }
}
