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
        $orders = Order::with(['user', 'supplier', 'orderItems'])->latest()->get();
        $dispatches = \App\Models\Dispatch::with(['user', 'client', 'dispatchItems'])->latest()->get();
        return view('orders.index', compact('orders', 'dispatches'));
    }

    public function show(Order $order)
    {
        $order->load('orderItems.item');
        return view('orders.show', compact('order'));
    }

    public function create()
    {
        $items = Item::all();
        $suppliers = \App\Models\Supplier::all();
        return view('orders.create', compact('items', 'suppliers'));
    }

    public function procurement()
    {
        // Items where quantity <= reorder_level
        $lowStockItems = Item::whereRaw('quantity <= COALESCE(reorder_level, 10)')
            ->with('category')
            ->get();
        
        $suppliers = \App\Models\Supplier::all();
        
        return view('orders.procurement', compact('lowStockItems', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $order = Order::create([
            'order_number' => 'PO-' . strtoupper(Str::random(8)),
            'created_by' => auth()->id(),
            'supplier_id' => $request->supplier_id,
            'status' => 'pending',
            'order_date' => now(),
            'notes' => $request->notes,
        ]);

        foreach ($request->items as $itemData) {
            // Only add selected items
            if (!isset($itemData['selected']) || $itemData['selected'] != '1') {
                continue;
            }

            $item = Item::find($itemData['id']);
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $item->id,
                'quantity_ordered' => $itemData['quantity'],
                'unit_price' => $item->price,
            ]);
        }

        \App\Models\ActivityLog::log('CREATED', $order, "Created purchase order #{$order->order_number}");
        return redirect()->route('orders.index')->with('success', 'Order created.');
    }

    public function update(Request $request, Order $order)
    {
        if ($request->status === 'completed' && $order->status !== 'completed') {
            $order->load('orderItems');
            foreach ($order->orderItems as $orderItem) {
                $item = $orderItem->item;
                
                \App\Models\InventoryTransaction::create([
                    'item_id' => $item->id,
                    'user_id' => auth()->id(),
                    'quantity_change' => $orderItem->quantity_ordered,
                    'type' => 'IN',
                    'reference' => $order->order_number,
                    'transaction_date' => now(),
                    'notes' => "Stock IN from Purchase Order",
                ]);
            }
            $order->update(['status' => 'completed']);
            \App\Models\ActivityLog::log('STATUS_CHANGE', $order, "Completed purchase order #{$order->order_number} and updated stock");
            return redirect()->back()->with('success', 'Order completed and stock updated.');
        }

        if ($request->has('status')) {
            $order->update(['status' => $request->status]);
            \App\Models\ActivityLog::log('STATUS_CHANGE', $order, "Changed order #{$order->order_number} status to " . strtoupper($request->status));
            return redirect()->back()->with('success', 'Order status updated to ' . $request->status);
        }

        return redirect()->back();
    }

    public function destroy(Order $order)
    {
        \App\Models\ActivityLog::log('DELETED', $order, "Deleted purchase order #{$order->order_number}");
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted.');
    }
}
