<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;

class UpdateStockFromTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:update-from-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculates all item quantities based on their transactions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $items = Item::with('inventoryTransactions')->get();

        foreach ($items as $item) {
            $in = $item->inventoryTransactions()->where('type', 'IN')->sum('quantity_change');
            $out = $item->inventoryTransactions()->where('type', 'OUT')->sum('quantity_change');
            
            // Adjustments might be positive or negative, but we will store absolute value and handle via logic.
            // Wait, in IN/OUT quantity_change is always positive. For ADJUSTMENT, it could be positive or negative.
            $adjustments = $item->inventoryTransactions()->where('type', 'ADJUSTMENT')->sum('quantity_change');

            $newQuantity = $in - $out + $adjustments;

            if ($item->quantity !== $newQuantity) {
                $item->update(['quantity' => $newQuantity]);
                $this->info("Updated {$item->name} stock to {$newQuantity}");
            }
        }

        $this->info('Stock updated successfully.');
    }
}
