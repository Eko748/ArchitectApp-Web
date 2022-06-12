<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProjectOwners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_owners', function (Blueprint $table) {
            $table->id();
            $table->integer('ownerId');
            $table->integer('projectId');
            $table->text('hasil_rab')->nullable();
            $table->enum('status',['Belum Bayar','Sudah Bayar']);
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
        Schema::dropIfExists('project_owners');
    }
}
