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
        Schema::create('pre_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained('orders')->onDelete('cascade');
            $table->date('preorder_start_date')->nullable();
            $table->date('preorder_end_date')->nullable();
            $table->date('estimated_completion_date')->nullable();
            $table->boolean('down_payment_required')->default(false);
            $table->decimal('down_payment_amount', 10, 2)->nullable();
            $table->date('final_payment_due_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_orders');
    }
};
