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
        Schema::create('tabungan', function (Blueprint $table) {
    $table->id();

    // 1 tabungan per room (shared)
    $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade')->unique();

    // optional: siapa yang bikin/tabungan
    $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

    $table->decimal('target_tabungan', 15, 2)->default(0);
    $table->decimal('total_terkumpul', 15, 2)->default(0);
    $table->string('status')->default('active');

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabungan');
    }
};
