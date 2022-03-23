<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKontrakKerjaKonsultansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kontrak_kerja_konsultans', function (Blueprint $table) {
            $table->id();
            $table->integer('tenderKonsultanId')->nullable();
            $table->integer('projectOwnerId')->nullable();
            $table->text('kontrakKerja');
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
        Schema::dropIfExists('kontrak_kerja_konsultans');
    }
};
