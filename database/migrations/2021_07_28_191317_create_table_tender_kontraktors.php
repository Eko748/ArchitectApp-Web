<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTenderKontraktors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tender_kontraktors', function (Blueprint $table) {
            $table->id();
            $table->integer('lelangKonsultanId');
            $table->integer('kontraktorId');
            $table->text('coverLetter');
            $table->text('cv');
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
        Schema::dropIfExists('tender_kontraktors');
    }
}
