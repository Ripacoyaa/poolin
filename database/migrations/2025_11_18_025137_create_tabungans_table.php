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
        Schema::create('tabungans', function (Blueprint $table) {
    $table->id(); // ID_Tabungan
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('cascade');

    $table->decimal('target_tabungan', 15, 2);
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
        Schema::dropIfExists('tabungans');
    }
};
