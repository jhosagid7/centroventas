<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTriggerForStockIngreso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER tr_updStockVenta AFTER INSERT ON articulo_ventas FOR EACH ROW
        BEGIN
        UPDATE articulos SET stock = stock - NEW.cantidad
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
        DB::unprepared("DROP TRIGGER tr_updStockVenta");
    }
}
