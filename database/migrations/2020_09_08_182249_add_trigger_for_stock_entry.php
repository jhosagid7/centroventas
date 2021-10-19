<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTriggerForStockEntry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER tr_udpStockIngreso AFTER INSERT ON articulo__ingresos FOR EACH ROW
        BEGIN
        UPDATE articulos SET stock = stock + NEW.cantidad
         WHERE articulos.id = NEW.articulo_id;
        END");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP TRIGGER tr_udpStockIngreso");
    }
}
