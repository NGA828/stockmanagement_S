<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Item;
use App\Models\Supplier;
use App\Models\Client;
use App\Models\Order;
use App\Models\Dispatch;

class SearchController extends Controller
{
    public function global(Request $request)
    {
        $q = $request->get('q');
        if (strlen($q) < 2) return response()->json([]);

        $items = Item::where('name', 'like', "%$q%")->orWhere('sku', 'like', "%$q%")
            ->take(5)->get()->map(fn($i) => ['type' => 'Item', 'title' => $i->name, 'url' => route('items.index'), 'meta' => $i->sku]);

        $suppliers = Supplier::where('name', 'like', "%$q%")
            ->take(3)->get()->map(fn($s) => ['type' => 'Supplier', 'title' => $s->name, 'url' => route('suppliers.index')]);

        $clients = Client::where('name', 'like', "%$q%")
            ->take(3)->get()->map(fn($c) => ['type' => 'Client', 'title' => $c->name, 'url' => route('clients.index')]);

        $orders = Order::where('order_number', 'like', "%$q%")
            ->take(3)->get()->map(fn($o) => ['type' => 'Purchase Order', 'title' => $o->order_number, 'url' => route('orders.show', $o)]);

        $dispatches = Dispatch::where('dispatch_number', 'like', "%$q%")
            ->take(3)->get()->map(fn($d) => ['type' => 'Dispatch', 'title' => $d->dispatch_number, 'url' => route('dispatches.show', $d)]);

        return response()->json($items->concat($suppliers)->concat($clients)->concat($orders)->concat($dispatches));
    }
}
