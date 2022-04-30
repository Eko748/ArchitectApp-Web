<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLelangKonsultans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lelang_konsultans', function (Blueprint $table) {
            $table->id();
            $table->integer('tenderKonsultanId');
            $table->string('title');
            $table->text('description');
            $table->integer('budget');
            $table->text('desain');
            $table->text('rab');
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
        Schema::dropIfExists('lelang_konsultans');
    }
}
