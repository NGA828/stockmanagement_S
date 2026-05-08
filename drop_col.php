<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (Schema::hasColumn('orders', 'supplier_id')) {
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn('supplier_id');
    });
    echo "Column 'supplier_id' dropped from 'orders' table.\n";
} else {
    echo "Column 'supplier_id' does not exist in 'orders' table.\n";
}
