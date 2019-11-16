<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChinchillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chinchillas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_ru');
            $table->string('name_en');
            $table->string('description_ru');
            $table->string('description_en');
            $table->bigInteger('birthday');
            $table->string('adultAvatar');
            $table->string('babyAvatar');
            $table->string('adultPhotos');
            $table->string('babyPhotos');
            $table->integer('mother')->nullable();
            $table->integer('father')->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('chinchillas');
    }
}
