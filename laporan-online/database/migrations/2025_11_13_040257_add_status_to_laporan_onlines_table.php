<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan_onlines', function (Blueprint $table) {
            // Tambah kolom status setelah tanggal
            $table->string('status')->default('pending')->after('tanggal');
        });
    }

    public function down(): void
    {
        Schema::table('laporan_onlines', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
