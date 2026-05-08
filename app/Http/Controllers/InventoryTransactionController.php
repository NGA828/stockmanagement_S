<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\InventoryTransaction;

class InventoryTransactionController extends Controller
{
    public function index()
    {
        $transactions = InventoryTransaction::with(['item', 'user'])->latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $items = Item::all();
        return view('transactions.create', compact('items'));
    }

    public function store(Request $request)
    {
        $allowedTypes = 'IN,OUT';
        if (in_array(auth()->user()->role, ['admin', 'stock_manager'])) {
            $allowedTypes .= ',ADJUSTMENT';
        }

        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity_change' => 'required|integer|min:1',
            'type' => 'required|in:' . $allowedTypes,
            'reference' => 'nullable|string'
        ]);

        $qtyChange = $request->quantity_change;
        $item = Item::findOrFail($request->item_id);

        if ($request->type === 'OUT') {
            if ($item->quantity < $qtyChange) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['quantity_change' => "Insufficient stock. Current stock is only {$item->quantity} units."]);
            }
            $qtyChange = -abs($qtyChange);
        }

        if ($request->type === 'ADJUSTMENT') {
            // Allow negative adjustments, but not below 0 total
            if ($item->quantity + $qtyChange < 0) {
                 return redirect()->back()
                    ->withInput()
                    ->withErrors(['quantity_change' => "Adjustment would result in negative stock. Current stock is {$item->quantity}."]);
            }
        }

        InventoryTransaction::create([
            'item_id' => $request->item_id,
            'user_id' => auth()->id(),
            'quantity_change' => $qtyChange,
            'type' => $request->type,
            'reference' => $request->reference,
            'transaction_date' => $request->transaction_date ?? now(),
            'notes' => $request->notes,
        ]);

        $item->increment('quantity', $qtyChange);

        // Check for low stock alert
        if ($item->quantity <= ($item->reorder_level ?? 10)) {
            $admins = \App\Models\User::whereIn('role', ['admin', 'stock_manager'])->get();
            \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\RestockAlert($item));
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction added and stock updated!');
    }
}
