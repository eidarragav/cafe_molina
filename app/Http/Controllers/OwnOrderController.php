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
            $ownorder->status = 'received';
            $ownorder->save();

            $products = $request->input('own_order_products', []);
            foreach ($products as $item) {
                $op = new OwnOrderProduct();
                $op->own_order_id = $ownorder->id;
                $op->product_id = $item['product_id'];
                $op->weight_id = $item['weight_id'];
                $op->quantity = $item['quantity'];
                $op->save();
            }

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OwnOrder  $ownOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(OwnOrder $ownOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OwnOrder  $ownOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OwnOrder $ownOrder)
    {
        //
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
