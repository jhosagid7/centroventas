<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditoIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credito_ingresos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingreso_id')->references('id')->on('ingresos');
            $table->foreignId('proveedor_credito_id')->references('id')->on('proveedor_creditos');
            $table->enum('estado_credito_ingreso', ['Pendiente', 'Pagado']);
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
        Schema::dropIfExists('credito_ingresos');
    }
}
