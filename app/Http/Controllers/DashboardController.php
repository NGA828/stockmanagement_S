<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use App\Models\InventoryTransaction;
use App\Models\User;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;

        $totalItems       = Item::count();
        $totalStockValue  = Item::all()->sum(fn($i) => $i->price * $i->quantity);
        $pendingOrders    = Order::where('status', 'pending')->count();
        $todayTransactions = InventoryTransaction::whereDate('transaction_date', today())->count();
        $lowStockItems    = Item::where('quantity', '<', 10)->orderBy('quantity')->take(5)->get();

        $totalUsers      = 0;
        $totalCategories = 0;
        $totalSuppliers  = \App\Models\Supplier::count();
        $needingAttention = 0;

        if ($role === 'admin') {
            $totalUsers      = User::count();
            $totalCategories = Category::count();
        } elseif ($role === 'stock_manager') {
            $totalCategories = Category::count();
            $needingAttention = Item::where('quantity', '<=', 10)->count();
        }

        // Recent transactions (last 5)
        $recentTransactions = InventoryTransaction::with('item')
            ->latest('transaction_date')
            ->take(5)
            ->get();

        // Recent orders (last 4)
        $recentOrders = Order::latest()->take(4)->get();

        // Chart Data: Stock by Category
        $categoriesData = Category::withCount('items')->get()->map(function($cat) {
            return [
                'name' => $cat->name,
                'count' => $cat->items_count
            ];
        });

        // Chart Data: Transactions last 7 days
        $txChartData = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $txChartData->push([
                'date' => now()->subDays($i)->format('d M'),
                'count' => InventoryTransaction::whereDate('transaction_date', $date)->count()
            ]);
        }

        // Financial Flow: Orders vs Dispatches (last 6 months)
        $monthlyFlow = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthLabel = $date->format('M Y');
            
            $purchaseVal = \App\Models\OrderItem::whereHas('order', function($q) use ($date) {
                $q->whereMonth('order_date', $date->month)->whereYear('order_date', $date->year)->where('status', 'completed');
            })->get()->sum(fn($oi) => $oi->quantity_ordered * $oi->unit_price);

            $dispatchVal = \App\Models\DispatchItem::whereHas('dispatch', function($q) use ($date) {
                $q->whereMonth('dispatch_date', $date->month)->whereYear('dispatch_date', $date->year)->where('status', 'shipped');
            })->get()->sum(fn($di) => $di->quantity * $di->unit_price);

            $monthlyFlow->push([
                'month' => $monthLabel,
                'purchases' => $purchaseVal,
                'sales' => $dispatchVal
            ]);
        }

        $totalDispatches = \App\Models\Dispatch::count();

        return view('dashboard', compact(
            'totalItems', 'totalStockValue', 'pendingOrders', 'todayTransactions', 'totalDispatches',
            'lowStockItems', 'totalUsers', 'totalCategories', 'totalSuppliers', 'needingAttention',
            'recentTransactions', 'recentOrders', 'categoriesData', 'txChartData', 'monthlyFlow'
        ));
    }
}
