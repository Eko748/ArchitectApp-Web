<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldTawaranHargaDesain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tender_konsultans', function (Blueprint $table) {
            
            $table->integer('tawaranHargaRab')->after('tawaranHargaDesain')->nullable()->change();
            $table->integer('tawaranHargaDesain')->nullable()->change();
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
