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
    Schema::table('tabungan', function (Blueprint $table) {
        if (!Schema::hasColumn('tabungan', 'target_tanggal')) {
            $table->date('target_tanggal')->nullable()->after('target_tabungan');
        }
    });
}

public function down(): void
{
    Schema::table('tabungan', function (Blueprint $table) {
        if (Schema::hasColumn('tabungan', 'target_tanggal')) {
            $table->dropColumn('target_tanggal');
        }
    });
}

};
