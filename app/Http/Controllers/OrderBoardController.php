<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OwnOrder;
use App\Models\MaquilaOrder;

class OrderBoardController extends Controller
{
    /**
     * Show orders board grouped by state ranges.
     *
     * Area1: states 1..4 (any selected = 'yes') + orders with status == 'received'
     * Area2: states 4..5 (any selected = 'yes')
     * Area3: states 6..10 (any selected = 'yes')
     */
    public function index(Request $request)
    {
        
        $selectedArea = (int) $request->query('area', 0); // 0 = all, 1,2,3 = single area

        // helper to get own orders matching a states range
        $fetchOwn = function (int $includeFrom, int $includeTo, int $excludeFrom, int $excludeTo) {
            return OwnOrder::with(['own_order_product.product','user','costumer', 'own_order_states'])

                // Debe tener al menos un estado "yes" entre includeFrom e includeTo
                ->whereExists(function ($q) use ($includeFrom, $includeTo) {
                    $q->select(DB::raw(1))
                        ->from('own_order_states')
                        ->whereColumn('own_order_states.own_order_id', 'own_orders.id')
                        ->whereBetween('own_order_states.state_id', [$includeFrom, $includeTo])
                        ->where('own_order_states.selected', 'yes');
                })

                // No debe tener ningún estado "yes" entre excludeFrom y excludeTo
                ->whereNotExists(function ($q) use ($excludeFrom, $excludeTo) {
                    $q->select(DB::raw(1))
                        ->from('own_order_states')
                        ->whereColumn('own_order_states.own_order_id', 'own_orders.id')
                        ->whereBetween('own_order_states.state_id', [$excludeFrom, $excludeTo])
                        ->where('own_order_states.selected', 'yes');
                });
        };

        // helper to get maquila orders matching a states range
        $fetchMaquila = function (int $includeFrom, int $includeTo, int $excludeFrom, int $excludeTo
        ) {
            return MaquilaOrder::with([
                    'maquila_meshes.mesh',
                    'maquila_services.service',
                    'user',
                    'costumer',
                    'maquila_order_states'
                ])

                // Debe tener al menos un estado "yes" entre includeFrom e includeTo
                ->whereExists(function ($q) use ($includeFrom, $includeTo) {
                    $q->select(DB::raw(1))
                        ->from('maquila_order_states')
                        ->whereColumn('maquila_order_states.maquila_order_id', 'maquila_orders.id')
                        ->whereBetween('maquila_order_states.state_id', [$includeFrom, $includeTo])
                        ->where('maquila_order_states.selected', 'yes');
                })

                // No debe tener ningún estado "yes" entre excludeFrom y excludeTo
                ->whereNotExists(function ($q) use ($excludeFrom, $excludeTo) {
                    $q->select(DB::raw(1))
                        ->from('maquila_order_states')
                        ->whereColumn('maquila_order_states.maquila_order_id', 'maquila_orders.id')
                        ->whereBetween('maquila_order_states.state_id', [$excludeFrom, $excludeTo])
                        ->where('maquila_order_states.selected', 'yes');
                });
        };

        // Area definitions
        $area1Own = $fetchOwn(1,4, 5,10)->get();
        $area1Maquila = $fetchMaquila(1,4, 5, 10)->get();



        // also include orders with status == 'received' (avoid duplicates)
        /*$receivedOwn = OwnOrder::with(['own_order_product.product','user','costumer'])
            ->where('status', 'received')
            ->whereNotIn('id', $area1Own->pluck('id')->toArray())
            ->get();

        

        $receivedMaquila = MaquilaOrder::with(['maquila_meshes.mesh','maquila_services.service','user','costumer'])
            ->where('status', 'received')
            ->whereNotIn('id', $area1Maquila->pluck('id')->toArray())
            ->get();
        */
        

        $area2Own = $fetchOwn(5,6, 7, 10)->get();
        $area2Maquila = $fetchMaquila(5,6,7,10)->get();

        $area3Own = $fetchOwn(7,10, 0,0)->get();
        $area3Maquila = $fetchMaquila(7,10,0,0)->get();


        // Combine each area and add a type flag for the view
        $area1 = collect()
            ->merge($area1Own->map(fn($o) => ['type' => 'own','order' => $o]))
            ->merge($area1Maquila->map(fn($o) => ['type' => 'maquila','order' => $o]))   ;
            //->merge($receivedOwn->map(fn($o) => ['type' => 'own','order' => $o]))
            //->merge($receivedMaquila->map(fn($o) => ['type' => 'maquila','order' => $o]));

        $area2 = collect()
            ->merge($area2Own->map(fn($o) => ['type' => 'own','order' => $o]))
            ->merge($area2Maquila->map(fn($o) => ['type' => 'maquila','order' => $o]));

        $area3 = collect()
            ->merge($area3Own->map(fn($o) => ['type' => 'own','order' => $o]))
            ->merge($area3Maquila->map(fn($o) => ['type' => 'maquila','order' => $o]));

        // optional: sort by entry_date or created_at desc
        $area1 = $area1->sortByDesc(fn($i) => $i['order']->created_at ?? $i['order']->entry_date ?? now());
        $area2 = $area2->sortByDesc(fn($i) => $i['order']->created_at ?? $i['order']->entry_date ?? now());
        $area3 = $area3->sortByDesc(fn($i) => $i['order']->created_at ?? $i['order']->entry_date ?? now());

        return view('manage_orders.index', compact('area1','area2','area3','selectedArea'));
    }
}