<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEventIdToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id')->nullable();                               // Menambahkan kolom event_id
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade'); // Menambahkan foreign key
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['event_id']); // Menghapus foreign key
            $table->dropColumn('event_id');    // Menghapus kolom event_id
        });
    }
}
