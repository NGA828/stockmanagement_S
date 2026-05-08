<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;

class DispatchController extends Controller
{
    public function index()
    {
        $dispatches = \App\Models\Dispatch::with(['client', 'user'])->latest()->get();
        return view('dispatches.index', compact('dispatches'));
    }

    public function create()
    {
        $clients = \App\Models\Client::all();
        $items = \App\Models\Item::where('quantity', '>', 0)->get();
        return view('dispatches.create', compact('clients', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'dispatch_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $dispatch = \App\Models\Dispatch::create([
            'dispatch_number' => 'DISP-' . strtoupper(uniqid()),
            'client_id' => $request->client_id,
            'created_by' => auth()->id(),
            'dispatch_date' => $request->dispatch_date,
            'status' => 'draft',
            'notes' => $request->notes,
        ]);

        foreach ($request->items as $itemData) {
            $item = \App\Models\Item::find($itemData['item_id']);
            $dispatch->dispatchItems()->create([
                'item_id' => $itemData['item_id'],
                'quantity' => $itemData['quantity'],
                'unit_price' => $item->price,
            ]);
        }

        ActivityLog::log('CREATED', $dispatch, "Created dispatch draft #{$dispatch->dispatch_number} for {$dispatch->client->name}");
        return redirect()->route('dispatches.index')->with('success', 'Dispatch draft created.');
    }

    public function show(\App\Models\Dispatch $dispatch)
    {
        $dispatch->load(['client', 'user', 'dispatchItems.item']);
        return view('dispatches.show', compact('dispatch'));
    }

    public function update(Request $request, \App\Models\Dispatch $dispatch)
    {
        if ($request->has('status') && $dispatch->status !== $request->status) {
            
            // Logic for finalized dispatch (Stock OUT)
            if ($request->status === 'shipped') {
                foreach ($dispatch->dispatchItems as $dItem) {
                    $item = $dItem->item;
                    if ($item->quantity < $dItem->quantity) {
                        return back()->with('error', "Insufficient stock for item: {$item->name}.");
                    }
                }

                // Log transactions (InventoryTransaction observer will handle the stock deduction)
                foreach ($dispatch->dispatchItems as $dItem) {
                    $item = $dItem->item;

                    \App\Models\InventoryTransaction::create([
                        'item_id' => $item->id,
                        'user_id' => auth()->id(),
                        'quantity_change' => -$dItem->quantity,
                        'type' => 'OUT',
                        'reference' => $dispatch->dispatch_number,
                        'transaction_date' => now(),
                        'notes' => "Dispatch to client: {$dispatch->client->name}",
                    ]);
                }
            }

            $dispatch->update(['status' => $request->status]);
            ActivityLog::log('STATUS_CHANGE', $dispatch, "Changed dispatch #{$dispatch->dispatch_number} status to " . strtoupper($request->status));
            return back()->with('success', "Dispatch status updated to {$request->status}.");
        }

        return back();
    }

    public function destroy(\App\Models\Dispatch $dispatch)
    {
        $dispatch->delete();
        return redirect()->route('dispatches.index')->with('success', 'Dispatch deleted successfully.');
    }
}
