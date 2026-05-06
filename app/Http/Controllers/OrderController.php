<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('orderItems.item');
        return view('orders.show', compact('order'));
    }

    public function create()
    {
        $items = Item::all();
        return view('orders.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $order = Order::create([
            'order_number' => 'PO-' . strtoupper(Str::random(8)),
            'created_by' => auth()->id(),
            'status' => 'pending',
            'order_date' => now(),
            'notes' => $request->notes,
        ]);

        foreach ($request->items as $itemData) {
            $item = Item::find($itemData['id']);
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $item->id,
                'quantity_ordered' => $itemData['quantity'],
                'unit_price' => $item->price,
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Order created.');
    }

    public function update(Request $request, Order $order)
    {
        if ($request->status === 'completed' && $order->status !== 'completed') {
            $order->load('orderItems');
            foreach ($order->orderItems as $orderItem) {
                $item = $orderItem->item;
                $item->increment('quantity', $orderItem->quantity_ordered);
            }
            $order->update(['status' => 'completed']);
            return redirect()->back()->with('success', 'Order completed and stock updated.');
        }

        if ($request->has('status')) {
            $order->update(['status' => $request->status]);
            return redirect()->back()->with('success', 'Order status updated to ' . $request->status);
        }

        return redirect()->back();
    }
}
