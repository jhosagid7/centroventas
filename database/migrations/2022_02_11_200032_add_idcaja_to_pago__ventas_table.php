<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdcajaToPagoVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pago__ventas', function (Blueprint $table) {

            $table->unsignedBigInteger('caja_id')->nullable()->after('venta_id');;


            $table->foreign('caja_id')->references('id')->on('cajas');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pago__ventas', function (Blueprint $table) {
            $table->dropForeign('pago__ventas_caja_id_foreign');
            $table->dropColumn("caja_id");
        });
    }
}
