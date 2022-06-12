<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKonstruksiOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konstruksi_owners', function (Blueprint $table) {
            $table->id();
            $table->integer('ownerId');
            $table->integer('konstruksiId');
            $table->enum('konfirmasi',[0,1,2]);
            $table->enum('status',["Belum Bayar","Sudah Bayar"]);
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
        Schema::dropIfExists('konstruksi_owners');
    }
}
