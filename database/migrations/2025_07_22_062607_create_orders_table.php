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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('order_status_id')->constrained('order_statuses')->onDelete('restrict');
            $table->foreignId('delivery_method_id')->constrained('delivery_methods')->onDelete('restrict');
            $table->foreignId('pickup_delivery_address_id')->nullable()->constrained('user_addresses')->onDelete('set null'); // Jika diantar ke alamat tertentu
            $table->dateTime('order_date')->useCurrent();
            $table->date('pickup_delivery_date');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('delivery_cost', 10, 2)->default(0.00);
            $table->text('notes')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
