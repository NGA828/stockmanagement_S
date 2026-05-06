<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\InventoryTransaction;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Stock Manager
        User::factory()->create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'role' => 'stock_manager',
        ]);

        // Warehouse Staff
        User::factory()->create([
            'name' => 'Staff User',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'role' => 'warehouse_staff',
        ]);

        $cat1 = Category::create(['name' => 'Electronics', 'description' => 'Electronic items']);
        $cat2 = Category::create(['name' => 'Furniture', 'description' => 'Office furniture']);

        $item1 = Item::create(['name' => 'Laptop', 'description' => 'Development laptop', 'price' => 1200.00, 'category_id' => $cat1->id, 'quantity' => 10]);
        $item2 = Item::create(['name' => 'Desk Chair', 'description' => 'Ergonomic chair', 'price' => 150.00, 'category_id' => $cat2->id, 'quantity' => 20]);

        InventoryTransaction::create([
            'item_id' => $item1->id,
            'user_id' => 1,
            'quantity_change' => 10,
            'type' => 'IN',
            'reference' => 'Initial Stock',
        ]);

        InventoryTransaction::create([
            'item_id' => $item2->id,
            'user_id' => 1,
            'quantity_change' => 20,
            'type' => 'IN',
            'reference' => 'Initial Stock',
        ]);
    }
}
