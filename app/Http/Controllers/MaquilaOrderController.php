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
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the form to create a maquila order.
     */
    public function index()
    {
        $users = User::orderBy('name')->get();
        $costumers = Costumer::orderBy('name')->get();
        $services = Service::orderBy('id')->get();
        $meshes = Mesh::orderBy('id')->get();
        $packages = Package::orderBy('package_type')->get();
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
            'presentation' => 'nullable|string',
            'management_criteria' => 'nullable|string',

            // arrays
            'maquila_services' => 'nullable|array',
            'maquila_services.*.service_id' => 'required_with:maquila_services|exists:services,id',
            'maquila_services.*.selection' => 'nullable|in:yes,no',

            'maquila_meshes' => 'nullable|array',
            'maquila_meshes.*.meshe_id' => 'required_with:maquila_meshes|exists:meshes,id',
            'maquila_meshes.*.weight' => 'nullable|numeric|min:0',

            'packages' => 'nullable|array',
            'packages.*.type' => 'nullable|string',
            'packages.*.mesh' => 'nullable|string',
            'packages.*.presentation' => 'nullable|string',
            'packages.*.kilograms' => 'nullable|numeric|min:0',
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
            $maquilaOrder->urgent_order = $validated['urgent_order'] ?? 'no';
            $maquilaOrder->status = 'received';
            $maquilaOrder->observations = $validated['observations'] ?? null;
            $maquilaOrder->net_weight = $request->input('net_weight', null);
            $maquilaOrder->packaging_type = $request->input('packaging_type', null);
            $maquilaOrder->packaging_quantity = $request->input('packaging_quantity', 0);
            $maquilaOrder->management_criteria = $request->input('management_criteria', 'no');
            $maquilaOrder->save();

            // Calculate departure date
            if ($request->filled('departure_date')) {
                $maquilaOrder->departure_date = $request->input('departure_date');
            } else {
                $proccessingDaysTotal = MaquilaOrder::whereDoesntHave('maquila_order_states', function ($q) {
                    $q->where('state_id', 11)
                      ->where('selected', 'yes');
                })
                ->get()
                ->sum(function ($o) {
                    if (!$o->departure_date || !$o->entry_date) return 1;

                    return Carbon::parse($o->departure_date)
                        ->diffInDays(Carbon::parse($o->entry_date));
                });

                $entry = Carbon::parse($maquilaOrder->entry_date ?? now());
                $totalWeight = (float) ($request->input('net_weight') ?? 1);
                if ($totalWeight <= 0) $totalWeight = 1;

                $calculateDays = (int) ceil(1 + (1 + $totalWeight / 525 + $totalWeight / 225 + $totalWeight / 500) + $proccessingDaysTotal);
                $maquilaOrder->departure_date = $entry->copy()->addDays($calculateDays);
            }
            $maquilaOrder->save();

            // maquila services
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

            // maquila meshes
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

            // create maquila_order_states: one record per existing state, state 1 = yes
            if (Schema::hasTable('states') && Schema::hasTable('maquila_order_states')) {
                $stateIds = DB::table('states')->pluck('id');
                if ($stateIds->isNotEmpty()) {
                    $now = now();
                    $inserts = [];
                    $minId = $stateIds->min();
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

            // packages
            if ($request->has('packages')) {
                foreach ($request->packages as $pkg) {
                    if (empty($pkg['type']) || empty($pkg['kilograms'])) {
                        continue;
                    }
                    
                    $package = Package::where('package_type', $pkg['type'])->first();
                    if (!$package) {
                        continue;
                    }

                    MaquilaPackage::create([
                        'maquila_order_id' => $maquilaOrder->id,
                        'package_id'       => $package->id,
                        'mesh'             => $pkg['mesh'] ?? '',
                        'kilograms'        => $pkg['kilograms'],
                        'presentation'     => $pkg['presentation'] ?? '',
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
        $costumers = Costumer::orderBy('name')->get();
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $maquilaOrder = MaquilaOrder::findOrFail($id);
        $maquilaOrder->entry_date = $request->input('entry_date', $maquilaOrder->entry_date);
        $maquilaOrder->urgent_order = $request->input('urgent_order', $maquilaOrder->urgent_order);
        $maquilaOrder->management_criteria = $request->input('management_criteria', $maquilaOrder->management_criteria);

        if ($request->filled('departure_date')) {
            $maquilaOrder->departure_date = $request->input('departure_date');
        } else {
            $totalWeight = (float) ($maquilaOrder->net_weight ?: 1);

            $proccessingDaysTotal = MaquilaOrder::whereDoesntHave('maquila_order_states', function ($q) {
                $q->where('state_id', 11)->where('selected', 'yes');
            })->get()->sum(function ($o) {
                if (!$o->departure_date || !$o->entry_date) return 1;
                return Carbon::parse($o->departure_date)
                    ->diffInDays(Carbon::parse($o->entry_date));
            });

            $entry = Carbon::parse($maquilaOrder->entry_date ?? now());
            $calculateDays = (int) ceil(1 + (1 + $totalWeight / 525 + $totalWeight / 225 + $totalWeight / 500) + $proccessingDaysTotal);
            $maquilaOrder->departure_date = $entry->copy()->addDays($calculateDays);
        }

        $maquilaOrder->save();

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

        $updated = DB::table('maquila_order_states')
            ->where('maquila_order_id', $maquilaOrder->id)
            ->where('state_id', $stateId)
            ->update(['selected' => $selected, 'updated_at' => now()]);

        if ($updated) {
            return response()->json(['message' => 'Selected state updated successfully']);
        } else {
            return response()->json(['message' => 'Selected state update processed (no rows affected)']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $maquilaOrder = MaquilaOrder::findOrFail($id);
        $maquilaOrder->delete();

        return redirect()->route('manage.orders.index')->with('success', 'Pedido maquila eliminado correctamente.');
    }

    public function show($id)
    {
        $order = MaquilaOrder::with([
            'user',
            'costumer',
            'maquila_meshes.mesh',
            'maquila_packages.package',
            'maquila_services.service',
            'toasts',
            'maquila_order_states.state'
        ])->findOrFail($id);

        return view('maquila_order.show', compact('order'));
    }

    public function maquila_pdf($id)
    {
        $order = MaquilaOrder::with([
            'user',
            'costumer',
            'maquila_meshes.mesh',
            'maquila_packages.package',
            'maquila_services.service',
            'toasts',
            'maquila_order_states.state'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('maquila_order.pdf.show', compact('order'));

        return $pdf->stream('orden_maquila_' . $order->id . '.pdf');
    }
}
