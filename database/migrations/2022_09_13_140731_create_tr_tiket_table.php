<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrTiketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_tiket', function (Blueprint $table) {
            $table->id();
            $table->text('nama');
            $table->text('deskripsi');
            $table->string('dokumen', 255);
            $table->string('url_pengembangan', 255)->default('-');
            $table->string('status', 20)->default('MENUNGGU');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_tiket');
    }
}
