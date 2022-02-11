<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditoVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credito_ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->references('id')->on('ventas');
            $table->foreignId('cliente_credito_id')->references('id')->on('cliente_creditos');
            $table->enum('estado_credito_venta', ['Pendiente', 'Pagado']);
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
        Schema::dropIfExists('credito_ventas');
    }
}
