<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrModulViewerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_modul_viewer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tr_modul_id');
            $table->string('gambar');
            $table->text('catatan');
            $table->timestamps();

            $table->foreign('tr_modul_id')->references('id')->on('tr_modul');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_modul_viewer');
    }
}
