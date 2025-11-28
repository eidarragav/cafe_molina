<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OwnOrder;
use App\Models\MaquilaOrder;
use App\Models\OwnOrderState;
use App\Models\OwnOrderProduct;
use App\Models\MaquilaOrderState;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(){
        $ownOrders = OwnOrder::count();
        $maquilaOrders = MaquilaOrder::count();
        $countIncompletedOwn = OwnOrderState::where('state_id', 11)
       ->where('selected', '=', 'no')
       ->count();
       $countIncompletedMaquila = MaquilaOrderState::where('state_id', 11)
       ->where('selected', '=', 'no')
       ->count();
       $incompleted = $countIncompletedOwn + $countIncompletedMaquila;

       $countCompletedOwn = OwnOrderState::where('state_id', 11)
       ->where('selected', '=', 'yes')
       ->count();
       $countCompletedMaquila = MaquilaOrderState::where('state_id', 11)
       ->where('selected', '=', 'yes')
       ->count();
       $completedOrders = $countCompletedOwn + $countCompletedMaquila;

       $kilosOwn = MaquilaOrder::sum('net_weight');
       $kilosMaquila = OwnOrderProduct::sum('weight_toast');
       $kilosTotal = $kilosOwn + $kilosMaquila;
       $urgentOrderOwn = OwnOrder::where('urgent_order', 'yes')->count();
       $urgentMaquuilaOrder = MaquilaOrder::where('urgent_order', 'yes')->count();
       $urgentOrders = $urgentOrderOwn + $urgentMaquuilaOrder;
       $topProduct = DB::table('own_order_products')
    ->join('products', 'own_order_products.product_id', '=', 'products.id')
    ->select('products.name', DB::raw('COUNT(*) as total'))
    ->groupBy('products.name')
    ->orderByDesc('total')
    ->first();

       $topCustomer = DB::table(function ($query) {
    $query
        ->select('costumer_id')
        ->from('own_orders')
        ->unionAll(
            DB::table('maquila_orders')->select('costumer_id')
        );
}, 'orders')
->join('costumers', 'orders.costumer_id', '=', 'costumers.id')
->select('costumers.name', DB::raw('COUNT(*) as total'))
->groupBy('costumers.name')
->orderByDesc('total')
->first();





        return view('dashboard.index', compact('ownOrders', 'maquilaOrders', 'incompleted', 'kilosTotal', 'urgentOrders', 'topCustomer', 'topProduct', 'completedOrders'));
    }
}
