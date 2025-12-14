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
        Schema::create('transaksis', function (Blueprint $table) {
    $table->id(); // ID_Transaksi
    $table->foreignId('tabungan_id')->constrained('tabungan')->onDelete('cascade');

    $table->date('tgl_transaksi');
    $table->decimal('nominal', 15, 2);
    $table->string('jenis'); // 'setoran' / 'penarikan'

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
