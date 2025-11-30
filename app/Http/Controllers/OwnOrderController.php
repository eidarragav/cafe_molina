<?php

namespace App\Http\Controllers;

use App\Models\OwnOrder;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Costumer;
use App\Models\Product;
use App\Models\Weight;
use App\Models\OwnOrderProduct;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class OwnOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $costumers = Costumer::all();
        $products = Product::all();
        $weights = Weight::all();
        return view('own_order.index', compact('users', 'costumers', 'products', 'weights'));
    }


    public function sumWeightsOwn(){
        $sum = OwnOrderProduct::sum('weight_toast');
        return response()->json($sum);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request, &$ownorder) {
            $ownorder = new OwnOrder();
            $ownorder->user_id = $request->input('user_id');
            $ownorder->costumer_id = $request->input('costumer_id');
            $ownorder->entry_date = $request->input('entry_date');
            $ownorder->urgent_order = $request->input('urgent_order');
            $ownorder->management_criteria = $request->input('management_criteria');
            $ownorder->status = 'received';
            
            $ownorder->save();

            $totalWeight = 0;
            $products = $request->input('own_order_products', []);

            foreach ($products as $item) {
                $op = new OwnOrderProduct();
                $op->own_order_id = $ownorder->id;
                $op->product_id = $item['product_id'];
                $op->weight_id = $item['weight_id'];
                $op->quantity = $item['quantity'];

                $op->type = $item['type'];

                $presentation = Weight::where('id',$item['weight_id'] )->value('presentation');
                $number = (int) rtrim($presentation, 'g');

                    
                if($item['weight']){
                    $totalWeight += $item['weight'];
                    $op->weight_toast = $item['weight'];
                }
                else{
                    if($item['type'] == 'grano'){
                        $op->weight_toast = (($number * $item['quantity'])/100) * 1.18 ;
                    }
                    else{
                        $op->weight_toast = (($number * $item['quantity'])/100) * 1.21 ;
                    }   
                }
                

                $op->save();
            }

            // calculate departure_date based on totalWeight
            $proccessingDaysTotal = OwnOrder::whereDoesntHave('own_order_states', function ($q) {
                $q->where('id', 11)
                ->where('selected', 'yes');
            })
            ->get()
            ->sum(function ($o) {
                if (!$o->departure_date || !$o->entry_date) return 1;

                return \Carbon\Carbon::parse($o->departure_date)
                    ->diffInDays(\Carbon\Carbon::parse($o->entry_date));
            });



            $entry = Carbon::parse($ownorder->entry_date);

            if($totalWeight == 0){
                $totalWeight = 1;
            }

            $calculateDays = 1 + (1 + $totalWeight/525+ $totalWeight/225   + $totalWeight/500) + $proccessingDaysTotal;

            $ownorder->departure_date = $entry->copy()->addDays($calculateDays);
            $ownorder->save();

            // create own_order_states: one record per existing state, all with selected = 'no'
            $stateIds = DB::table('states')->pluck('id');
            if ($stateIds->isNotEmpty()) {
                $now = now();
                $inserts = [];
                $minId = 1;
                foreach ($stateIds as $stateId) {
                    $inserts[] = [
                        'own_order_id' => $ownorder->id,
                        'state_id' => $stateId,
                        'selected' => $stateId == $minId ? 'yes' : 'no',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
                DB::table('own_order_states')->insert($inserts);
            }
        });

        return redirect()->route('own-orders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OwnOrder  $ownOrder
     * @return \Illuminate\Http\Response
     */
    public function show(OwnOrder $ownOrder)
    {
        $ownOrder->load([
            'user',
            'costumer',
            'own_order_product.product',
            'own_order_product.weight',
            // if you have own_order_states relation:
            //'ownOrderStates.state'
        ]);

        return view('own_order.show', compact('ownOrder'));
    }

    public function ownorder_pdf($id)
    {
        $ownOrder = OwnOrder::with([
            'user',
            'costumer',
            'own_order_product.product',
            'own_order_product.weight',
        
        ])->find($id);


        $pdf = Pdf::loadView('own_order.pdf.show', compact('ownOrder'));

        return $pdf->stream('reporte.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OwnOrder  $ownOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(OwnOrder $ownOrder)
    {
        $costumer_id = $ownOrder->costumer_id;
        $costumer = Costumer::where('id', $costumer_id)->first();

        $products = Product::all();
        $weights = Weight::all();

    return view('own_order.edit', compact('ownOrder', 'costumer', 'products', 'weights'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OwnOrder  $ownOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $own_order= OwnOrder::where('id', $id)->first();
        // Actualizar campos generales

        $own_order->entry_date = $request->input('entry_date');
        $own_order->urgent_order = $request->input('urgent_order');
        $own_order->departure_date = $request->input('departure_date');
        $own_order->management_criteria = $request->input('management_criteria');
        $own_order->save();


        $totalWeight = OwnOrderProduct::where('own_order_id', $id)->sum('weight_toast');

        if(!$request->input('departure_date')){
            $proccessingDaysTotal = OwnOrder::whereDoesntHave('own_order_states', function ($q) {
            $q->where('id', 11)->where('selected', 'yes');
            })->get()->sum(function ($o) {
                if (!$o->departure_date || !$o->entry_date) return 1;
                return \Carbon\Carbon::parse($o->departure_date)
                    ->diffInDays(\Carbon\Carbon::parse($o->entry_date));
            });

            $entry = Carbon::parse($own_order->entry_date);
            $calculateDays = 1 + (1 + max($totalWeight,1)/525  + max($totalWeight,1)/225 +max($totalWeight,1)/500) + $proccessingDaysTotal;
            $own_order->departure_date = $entry->copy()->addDays($calculateDays);
            $own_order->save();
        }
        

    return redirect()->route('own-orders.index')->with('success', 'Pedido actualizado correctamente.');
    }

    /**
     * Update selected state for an OwnOrder.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id OwnOrder ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSelectedState(Request $request, $id)
    {
        $request->validate([
            'state_id' => 'required|integer|exists:states,id',
            'selected' => 'required|string|in:yes,no',
        ]);

        $ownOrder = OwnOrder::findOrFail($id);

        $stateId = $request->input('state_id');
        $selected = $request->input('selected');

        // Update the selected state record
        $updated = \DB::table('own_order_states')
            ->where('own_order_id', $ownOrder->id)
            ->where('state_id', $stateId)
            ->update(['selected' => $selected, 'updated_at' => now()]);

        if ($updated) {
            return response()->json(['message' => 'Selected state updated successfully']);
        } else {
            // Log issue or still treat as success to avoid frontend error alert
            // \Log::warning('Selected state update affected zero rows', ['own_order_id' => $ownOrder->id, 'state_id' => $stateId]);
            return response()->json(['message' => 'Selected state update processed (no rows affected)']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OwnOrder  $ownOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(OwnOrder $ownOrder)
    {
        //
    }
}
