<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->enum("type", ["in", "out", "init"]);
            $table->foreignId("purchase_detail_id")->nullable()->constrained('purchase_details')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId("sale_detail_id")->nullable()->constrained('sale_details')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId("inventory_id")->constrained('inventories')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId("user_id")->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->float("quantity")->default(0);
            $table->float("available")->default(0);
            $table->float("purchase_cost")->default(0);
            $table->float("sale_cost")->default(0);
            $table->float("total_purchase_cost")->default(0);
            $table->float("total_sale_cost")->default(0);
            $table->float("total_profit")->default(0);
            $table->float("total_loss")->default(0);
            $table->float("total_value")->default(0);
            $table->string("description")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
