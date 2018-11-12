<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imdb_id')->unique();
            $table->unsignedInteger('serie_id');
            $table->string('title');
            $table->unsignedInteger('season');
            $table->unsignedInteger('episode');
            $table->dateTime('released_at')->nullable();
            $table->timestamps();

            $table->foreign('serie_id')->references('id')->on('series');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Episodes');
    }
}
