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
        $pendingOrders    = Order::where('status', 'pending')->count();
        $todayTransactions = InventoryTransaction::whereDate('transaction_date', today())->count();
        $lowStockItems    = Item::where('quantity', '<', 10)->orderBy('quantity')->take(5)->get();

        $totalUsers      = 0;
        $totalCategories = 0;
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

        return view('dashboard', compact(
            'totalItems', 'pendingOrders', 'todayTransactions',
            'lowStockItems', 'totalUsers', 'totalCategories', 'needingAttention',
            'recentTransactions', 'recentOrders'
        ));
    }
}
