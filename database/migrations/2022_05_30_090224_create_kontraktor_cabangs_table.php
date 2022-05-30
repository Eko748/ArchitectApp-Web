<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKontraktorCabangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kontraktor_cabangs', function (Blueprint $table) {
            $table->id();
            $table->integer('kontraktorId');
            $table->string('nama_tim');
            $table->text('slug');
            $table->text('description');
            $table->integer('jumlah_tim');
            $table->integer('harga_kontrak');
            $table->enum('isLelang',[0,1]);
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
        Schema::dropIfExists('kontraktor_cabangs');
    }
}
