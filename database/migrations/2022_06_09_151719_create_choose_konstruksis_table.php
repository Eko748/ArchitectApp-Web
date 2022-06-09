<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChooseKonstruksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('choose_konstruksis', function (Blueprint $table) {
            $table->id();
            $table->integer('konstruksiOwnerId');
            $table->string('kota');
            $table->string('kecamatan');
            $table->string('desa');
            $table->string('jalan');
            $table->date('mulaiKonstruksi');
            $table->text('RAB');
            $table->text('desain');
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
        Schema::dropIfExists('choose_konstruksis');
    }
}
