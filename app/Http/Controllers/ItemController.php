<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->get();
        return view('items.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('items.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'reorder_level' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $data['image'] = $path;
        }

        $item = Item::create($data);
        ActivityLog::log('CREATED', $item, "Created new item: {$item->name}");
        return redirect()->route('items.index')->with('success', 'Item created.');
    }

    public function edit(Item $item)
    {
        $categories = Category::all();
        return view('items.form', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'reorder_level' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $path = $request->file('image')->store('items', 'public');
            $data['image'] = $path;
        }

        $item->update($data);
        ActivityLog::log('UPDATED', $item, "Updated item details for: {$item->name}");

        // Check for low stock alert
        if ($item->quantity <= ($item->reorder_level ?? 10)) {
            $admins = \App\Models\User::whereIn('role', ['admin', 'stock_manager'])->get();
            \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\RestockAlert($item));
        }

        return redirect()->route('items.index')->with('success', 'Item updated.');
    }

    public function destroy(Item $item)
    {
        ActivityLog::log('DELETED', $item, "Soft-deleted item: {$item->name}");
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Item deleted.');
    }
}
