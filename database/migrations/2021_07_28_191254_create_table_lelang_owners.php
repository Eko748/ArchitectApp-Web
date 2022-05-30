<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLelangOwners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lelang_owners', function (Blueprint $table) {
            $table->id();
            $table->integer('ownerId');
            $table->string('title');
            $table->text('description');
            $table->integer('status');
            $table->integer('budgetFrom');
            $table->integer('budgetTo');
            $table->string('gayaDesain');
            $table->enum('RAB', [1, 0]);
            $table->enum('desain', [1, 0]);
            // $table->string('luas');
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
        Schema::dropIfExists('lelang_owners');
    }
}
