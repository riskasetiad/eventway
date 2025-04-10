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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tiket_id');
            $table->foreign('tiket_id')->references('id')->on('tikets')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('jenis_kelamin');
            $table->date('tgl_lahir');
            $table->string('email');
            $table->integer('jumlah');
            $table->integer('total_harga');
            $table->string('payment_type')->null;
            $table->enum('status_pembayaran', ['pending','berhasil','gagal']);
            $table->enum('status_tiket', ['sudah ditukar','belum ditukar']);
            $table->string('snap_token')->null;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
