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
        $users = User::orderBy('name')->get();
        $costumers = Costumer::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $weights = Weight::orderBy('id')->get();
        return view('own_order.index', compact('users', 'costumers', 'products', 'weights'));
    }

    public function sumWeightsOwn()
    {
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
        return redirect()->route('own-orders.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'costumer_id' => 'required|exists:costumers,id',
            'entry_date' => 'required|date',
            'urgent_order' => 'nullable|in:yes,no',
            'management_criteria' => 'nullable|in:yes,no',
            'own_order_products' => 'nullable|array',
            'own_order_products.*.product_id' => 'required_with:own_order_products|exists:products,id',
            'own_order_products.*.weight_id' => 'required_with:own_order_products|exists:weights,id',
            'own_order_products.*.quantity' => 'required_with:own_order_products|integer|min:1',
        ]);

        DB::transaction(function () use ($request, &$ownorder) {
            $ownorder = new OwnOrder();
            $ownorder->user_id = $request->input('user_id');
            $ownorder->costumer_id = $request->input('costumer_id');
            $ownorder->entry_date = $request->input('entry_date');
            $ownorder->urgent_order = $request->input('urgent_order', 'no');
            $ownorder->management_criteria = $request->input('management_criteria', 'no');
            $ownorder->status = 'received';
            $ownorder->save();

            $totalWeight = 0;
            $products = $request->input('own_order_products', []);

            foreach ($products as $item) {
                if (empty($item['product_id']) || empty($item['weight_id'])) continue;

                $op = new OwnOrderProduct();
                $op->own_order_id = $ownorder->id;
                $op->product_id = $item['product_id'];
                $op->weight_id = $item['weight_id'];
                $op->quantity = $item['quantity'] ?? 1;
                $op->type = $item['type'] ?? 'grano';

                $presentation = Weight::where('id', $item['weight_id'])->value('presentation');
                $number = (int) rtrim((string) $presentation, 'g');
                if ($number <= 0) $number = 500;

                if (!empty($item['weight']) && (float) $item['weight'] > 0) {
                    $weightVal = (float) $item['weight'];
                    $totalWeight += $weightVal;
                    $op->weight_toast = $weightVal;
                } else {
                    $qty = (int) ($item['quantity'] ?? 1);
                    if ($op->type === 'grano') {
                        $op->weight_toast = round((($number * $qty) / 1000) / 0.82, 2);
                    } else {
                        $op->weight_toast = round((($number * $qty) / 1000) / 0.785, 2);
                    }
                    $totalWeight += $op->weight_toast;
                }

                $op->save();
            }

            // Departure date calculation
            if ($request->filled('departure_date')) {
                $ownorder->departure_date = $request->input('departure_date');
            } else {
                $proccessingDaysTotal = OwnOrder::whereDoesntHave('own_order_states', function ($q) {
                    $q->where('state_id', 11)
                      ->where('selected', 'yes');
                })
                ->get()
                ->sum(function ($o) {
                    if (!$o->departure_date || !$o->entry_date) return 1;

                    return Carbon::parse($o->departure_date)
                        ->diffInDays(Carbon::parse($o->entry_date));
                });

                $entry = Carbon::parse($ownorder->entry_date ?? now());
                if ($totalWeight <= 0) {
                    $totalWeight = 1;
                }

                $calculateDays = (int) ceil(1 + (1 + $totalWeight / 525 + $totalWeight / 225 + $totalWeight / 500) + $proccessingDaysTotal);
                $ownorder->departure_date = $entry->copy()->addDays($calculateDays);
            }
            $ownorder->save();

            // create own_order_states
            $stateIds = DB::table('states')->pluck('id');
            if ($stateIds->isNotEmpty()) {
                $now = now();
                $inserts = [];
                $minId = $stateIds->min();
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

        return redirect()->route('own-orders.index')->with('success', 'Pedido propio creado correctamente.');
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
            'toasts',
            'own_order_states.state',
        ]);

        $sumW = OwnOrderProduct::where('own_order_id', $ownOrder->id)->sum('weight_toast');

        return view('own_order.show', compact('ownOrder', 'sumW'));
    }

    public function ownorder_pdf($id)
    {
        $ownOrder = OwnOrder::with([
            'user',
            'costumer',
            'own_order_product.product',
            'own_order_product.weight',
            'toasts',
            'own_order_states.state'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('own_order.pdf.show', compact('ownOrder'));

        return $pdf->stream('orden_propia_' . $ownOrder->id . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OwnOrder  $ownOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(OwnOrder $ownOrder)
    {
        $costumers = Costumer::orderBy('name')->get();
        $costumer = $ownOrder->costumer;
        $products = Product::all();
        $weights = Weight::all();

        return view('own_order.edit', compact('ownOrder', 'costumer', 'costumers', 'products', 'weights'));
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
        $own_order = OwnOrder::findOrFail($id);

        $own_order->costumer_id = $request->input('costumer_id', $own_order->costumer_id);
        $own_order->entry_date = $request->input('entry_date', $own_order->entry_date);
        $own_order->urgent_order = $request->input('urgent_order', $own_order->urgent_order);
        $own_order->management_criteria = $request->input('management_criteria', $own_order->management_criteria);

        if ($request->filled('departure_date')) {
            $own_order->departure_date = $request->input('departure_date');
        } else {
            $totalWeight = (float) OwnOrderProduct::where('own_order_id', $id)->sum('weight_toast');
            if ($totalWeight <= 0) $totalWeight = 1;

            $proccessingDaysTotal = OwnOrder::whereDoesntHave('own_order_states', function ($q) {
                $q->where('state_id', 11)->where('selected', 'yes');
            })->get()->sum(function ($o) {
                if (!$o->departure_date || !$o->entry_date) return 1;
                return Carbon::parse($o->departure_date)
                    ->diffInDays(Carbon::parse($o->entry_date));
            });

            $entry = Carbon::parse($own_order->entry_date ?? now());
            $calculateDays = (int) ceil(1 + (1 + $totalWeight / 525 + $totalWeight / 225 + $totalWeight / 500) + $proccessingDaysTotal);
            $own_order->departure_date = $entry->copy()->addDays($calculateDays);
        }

        $own_order->save();

        return redirect()->route('manage.orders.index')->with('success', 'Pedido propio actualizado correctamente.');
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

        $updated = DB::table('own_order_states')
            ->where('own_order_id', $ownOrder->id)
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
        $ownOrder = OwnOrder::findOrFail($id);
        $ownOrder->delete();

        return redirect()->route('manage.orders.index')->with('success', 'Pedido propio eliminado correctamente.');
    }
}
