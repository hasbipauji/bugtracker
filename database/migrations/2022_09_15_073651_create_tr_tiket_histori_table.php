<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrTiketHistoriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_tiket_histori', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tr_tiket_id');
            $table->text('keterangan');
            $table->timestamps();

            $table->foreign('tr_tiket_id')->references('id')->on('tr_tiket')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_tiket_histori');
    }
}
