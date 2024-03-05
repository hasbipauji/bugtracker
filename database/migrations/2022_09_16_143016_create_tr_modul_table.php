<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrModulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_modul', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tr_tiket_id');
            $table->string('nama', 100);
            $table->string('status', 20)->default('MENUNGGU');
            $table->integer('lama_pengerjaan');
            $table->date('waktu_mulai')->nullable();
            $table->date('waktu_tutup')->nullable();
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
        Schema::dropIfExists('tr_modul');
    }
}
