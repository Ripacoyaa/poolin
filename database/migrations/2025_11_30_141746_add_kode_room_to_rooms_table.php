<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::table('rooms', function (Blueprint $table) {
        if (!Schema::hasColumn('rooms', 'kode_room')) {
            $table->string('kode_room', 20)->nullable()->after('nama_room');
        }

        // jangan change kalau kolomnya gak ada
        if (Schema::hasColumn('rooms', 'tgl_buat')) {
            $table->date('tgl_buat')->nullable()->change();
        }
    });
}

public function down(): void
{
    Schema::table('rooms', function (Blueprint $table) {
        if (Schema::hasColumn('rooms', 'kode_room')) {
            $table->dropColumn('kode_room');
        }

        // optional: balikin perubahan tgl_buat kalau memang ada
        // if (Schema::hasColumn('rooms', 'tgl_buat')) {
        //     $table->date('tgl_buat')->nullable(false)->change();
        // }
    });
}
};
