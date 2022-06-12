<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderKontraktorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_kontraktors', function (Blueprint $table) {
            $table->id();
            $table->integer('konstruksiOwnerId');
            $table->integer('ownerId');
            $table->integer('kontraktorId');
            $table->integer('konstruksiId');
            // $table->integer('status');
            $table->enum('status',['Belum Bayar','Sudah Bayar']);
            $table->string('status_order');
            $table->string('transaction_id');
            $table->string('order_id');
            $table->string('gross_amount');
            $table->string('payment_type');
            $table->string('payment_code')->nullable();
            $table->string('pdf_url')->nullable();
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
        Schema::dropIfExists('order_kontraktors');
    }
}
