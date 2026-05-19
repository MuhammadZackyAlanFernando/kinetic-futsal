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
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('bukti_pembayaran')->nullable()->after('status');
            $table->string('nama_rekening')->nullable()->after('bukti_pembayaran');
            $table->string('nomor_rekening')->nullable()->after('nama_rekening');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['bukti_pembayaran', 'nama_rekening', 'nomor_rekening']);
        });
    }
};
