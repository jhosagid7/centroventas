<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferencias', function (Blueprint $table) {
            $table->id();
            $table->enum('accion', ['Mayor a Detal', 'Detal a Mayor']);
            $table->unsignedInteger('origen_id');
            $table->string('origenNombreProducto', 100);
            $table->unsignedInteger('origenStockInicial');
            $table->unsignedInteger('origenStockFinal');
            $table->unsignedInteger('origenUnidades');
            $table->string('origenVender_al',20);
            $table->unsignedInteger('cantidadRestarOrigen');
            $table->unsignedInteger('destino_id');
            $table->string('destinoNombreProducto', 100);
            $table->unsignedInteger('destinoStockInicial');
            $table->unsignedInteger('destinoStockFinal');
            $table->unsignedInteger('destinoUnidades');
            $table->string('destinoVender_al', 20);
            $table->unsignedInteger('cantidadSumarDestino');
            $table->string('operador', 100);
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
        Schema::dropIfExists('transferencias');
    }
}
