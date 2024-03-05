<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrProgrammerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_programmer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tr_tiket_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('tr_tiket_id')->references('id')->on('tr_tiket')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_programmer');
    }
}
