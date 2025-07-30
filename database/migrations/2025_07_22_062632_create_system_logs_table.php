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
        Schema::create('system_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('timestamp')->useCurrent();
            $table->enum('log_level', ['INFO', 'WARN', 'ERROR', 'DEBUG']);
            $table->string('event_type', 100);
            $table->text('message');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // User yang melakukan aksi
            $table->string('ip_address', 45)->nullable();
            $table->json('metadata')->nullable(); // Untuk data tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_logs');
    }
};
