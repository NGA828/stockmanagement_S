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
        if ($request->type === 'OUT') {
            $qtyChange = -abs($qtyChange);
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

        $item = Item::find($request->item_id);
        $item->increment('quantity', $qtyChange);

        return redirect()->route('transactions.index')->with('success', 'Transaction added and stock updated!');
    }
}
