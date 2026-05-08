<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with('user')->latest()->get();
        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.form');
    }

    public function store(Request $request)
    {
        $request->validate(['type' => 'required|string|in:inventory,transactions,orders']);

        $type = $request->type;
        $title = "";
        $headers = [];
        $data = [];

        if ($type === 'inventory') {
            $title = "Current Inventory Valuation Report";
            $headers = ['SKU', 'Item Name', 'Category', 'Qty', 'Price', 'Total'];
            $items = \App\Models\Item::with('category')->get();
            foreach ($items as $item) {
                $data[] = [
                    'sku' => $item->sku ?? 'N/A',
                    'name' => $item->name,
                    'category' => $item->category->name ?? 'N/A',
                    'qty' => $item->quantity,
                    'price' => number_format($item->price, 2) . ' FCFA',
                    'total' => number_format($item->price * $item->quantity, 2) . ' FCFA',
                ];
            }
        } elseif ($type === 'transactions') {
            $title = "Inventory Transactions History";
            $headers = ['Date', 'Item', 'Type', 'Qty', 'User', 'Reference'];
            $txs = \App\Models\InventoryTransaction::with(['item', 'user'])->latest()->take(50)->get();
            foreach ($txs as $tx) {
                $data[] = [
                    'date' => $tx->transaction_date->format('d/m/Y'),
                    'item' => $tx->item->name ?? 'N/A',
                    'type' => $tx->type,
                    'qty' => $tx->quantity_change,
                    'user' => $tx->user->name ?? 'N/A',
                    'ref' => $tx->reference ?? '—',
                ];
            }
        } else {
            $title = "Recent Purchase Orders";
            $headers = ['Order #', 'Supplier', 'Date', 'Status', 'Total'];
            $orders = \App\Models\Order::with('supplier')->latest()->take(30)->get();
            foreach ($orders as $order) {
                $data[] = [
                    'no' => $order->order_number,
                    'supplier' => $order->supplier->name ?? 'N/A',
                    'date' => $order->order_date->format('d/m/Y'),
                    'status' => strtoupper($order->status),
                    'total' => number_format($order->total_amount ?? 0, 2) . ' FCFA',
                ];
            }
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf', compact('title', 'headers', 'data', 'type'));
        
        $fileName = 'reports/' . $type . '_' . time() . '.pdf';
        \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $pdf->output());

        Report::create([
            'type' => $type,
            'generated_date' => now(),
            'generated_by' => auth()->id(),
            'parameters' => $request->except(['_token']),
            'file_path' => $fileName,
        ]);

        return redirect()->route('reports.index')->with('success', 'Report generated successfully.');
    }
}
