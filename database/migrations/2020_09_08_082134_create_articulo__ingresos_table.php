<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticuloIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulo__ingresos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cantidad')->nullable();
            $table->decimal('precio_costo_unidad', 25, 9)->nullable();
            $table->foreignId('ingreso_id')->references('id')->on('ingresos');
            $table->foreignId('articulo_id')->references('id')->on('articulos');
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
        Schema::dropIfExists('articulo__ingresos');
    }
}
