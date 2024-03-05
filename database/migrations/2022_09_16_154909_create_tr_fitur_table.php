<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrFiturTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_fitur', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tr_modul_id');
            $table->string('nama');
            $table->timestamps();

            $table->foreign('tr_modul_id')->references('id')->on('tr_modul')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_fitur');
    }
}
