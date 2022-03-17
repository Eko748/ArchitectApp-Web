<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenderKonsultansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tender_konsultans', function (Blueprint $table) {
            $table->id();
            $table->integer('lelangOwnerId');
            $table->integer('konsultanId');
            $table->text('coverLetter');
            $table->text('cv');
            $table->integer('tawaranHarga');
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
        Schema::dropIfExists('tender_konsultans');
    }
}
