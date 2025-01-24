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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('image');
            $table->string('title');
            $table->unsignedBigInteger('kategori_id');
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->string('kota');
            $table->string('lokasi');
            $table->string('url_lokasi');
            $table->longText('deskripsi');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->enum('status', ['pending', 'approve', 'reject'])->default('pending');
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
