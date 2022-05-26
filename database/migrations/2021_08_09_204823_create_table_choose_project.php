<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableChooseProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('choose_projects', function (Blueprint $table) {
            $table->id();
            $table->integer('projectOwnerId');
            $table->enum('RAB', [1, 0]);
            $table->enum('desain', [1, 0]);
            $table->decimal('panjang');
            $table->decimal('lebar');

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
        Schema::dropIfExists('choose_projects');
    }
}
