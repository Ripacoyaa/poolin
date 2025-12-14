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
    Schema::table('group_transaksis', function (Blueprint $table) {
        if (!Schema::hasColumn('group_transaksis', 'tgl_transaksi')) {
            $table->date('tgl_transaksi')->nullable()->after('user_id');
        }
    });
}

public function down(): void
{
    Schema::table('group_transaksis', function (Blueprint $table) {
        if (Schema::hasColumn('group_transaksis', 'tgl_transaksi')) {
            $table->dropColumn('tgl_transaksi');
        }
    });
}
};
