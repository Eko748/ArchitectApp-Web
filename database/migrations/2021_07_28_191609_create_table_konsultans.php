<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKonsultans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konsultans', function (Blueprint $table) {
            $table->id();
            $table->integer('userId');
            $table->string('telepon', 13)->nullable();
            $table->string('website')->nullable();
            $table->string('instagram')->nullable();
            $table->text('about')->nullable();
            $table->text('alamat')->nullable();
            $table->string('slug');
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
        Schema::dropIfExists('konsultans');
    }
}
