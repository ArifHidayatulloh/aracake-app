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
        Schema::create('order_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->timestamp('timestamp')->useCurrent();
            $table->foreignId('actor_user_id')->nullable()->constrained('users')->onDelete('set null'); // Admin/user yang melakukan aksi
            $table->enum('event_type', ['ORDER_CREATED','PAYMENT_PROOF_UPLOADED', 'PAYMENT_CONFIRMED','ORDER_PROCESSED', 'DELIVERY_ASSIGNED', 'ORDER_CANCELLED','ORDER_COMPLETED']);
            $table->string('old_value', 255)->nullable();
            $table->string('new_value', 255)->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_logs');
    }
};
