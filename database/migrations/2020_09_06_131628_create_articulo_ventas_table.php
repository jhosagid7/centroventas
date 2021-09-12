<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticuloVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulo_ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cantidad')->nullable();
            $table->decimal('precio_costo_unidad', 25, 9)->nullable();
            $table->decimal('precio_venta_unidad', 25, 9)->nullable();
            $table->decimal('porEspecial', 25, 2)->nullable();
            $table->unsignedInteger('isDolar')->nullable();
            $table->unsignedInteger('isPeso')->nullable();
            $table->unsignedInteger('isTransPunto')->nullable();
            $table->unsignedInteger('isMixto')->nullable();
            $table->unsignedInteger('isEfectivo')->nullable();
            $table->decimal('descuento', 25, 3)->nullable();
            $table->foreignId('articulo_id')->references('id')->on('articulos');
            $table->foreignId('venta_id')->references('id')->on('ventas');
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
        Schema::dropIfExists('articulo_ventas');
    }
}
