<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            // deadline: Kapan buku harus balik (misal tgl_pinjam + 7 hari)
            $table->date('deadline')->after('tanggal_pinjam')->nullable();
            // denda: Nominal uang yang harus dibayar kalau telat
            $table->integer('denda')->default(0)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropColumn(['deadline', 'denda']);
        });
    }
};
