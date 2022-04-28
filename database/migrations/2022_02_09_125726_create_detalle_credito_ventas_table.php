<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleCreditoVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_credito_ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->references('id')->on('ventas')->onDelete('cascade');
            $table->foreignId('cliente')->references('id')->on('personas');
            $table->foreignId('operador')->references('id')->on('users');
            $table->foreignId('caja_id')->references('id')->on('cajas');
            $table->decimal('moto', 25, 3)->nullable();
            $table->decimal('abono', 25, 3)->nullable();
            $table->decimal('resta', 25, 3)->nullable();
            $table->decimal('descuento', 25, 3)->nullable();
            $table->decimal('incremento', 25, 3)->nullable();
            $table->text('Observaciones')->nullable();
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
        Schema::dropIfExists('detalle_credito_ventas');
    }
}
