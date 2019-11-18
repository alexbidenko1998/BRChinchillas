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
            $table->string('name_ru')->nullable();
            $table->string('name_en')->nullable();
            $table->string('description_ru')->nullable();
            $table->string('description_en')->nullable();
            $table->bigInteger('birthday')->nullable();
            $table->string('adultAvatar')->nullable();
            $table->string('babyAvatar')->nullable();
            $table->string('adultPhotos')->nullable();
            $table->string('babyPhotos')->nullable();
            $table->integer('mother')->nullable();
            $table->integer('father')->nullable();
            $table->integer('status')->nullable();
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
