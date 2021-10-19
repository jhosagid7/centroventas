<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_stocks', function (Blueprint $table) {
            $table->id();
            $table->decimal('stock_inicio', 10, 2)->nullable();
            $table->decimal('stock_cierre', 10, 2)->nullable();
            $table->decimal('stock_dif', 10, 2)->nullable();
            $table->decimal('stock_cierre_operador', 10, 2)->nullable();
            $table->string('observaciones')->nullable();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('articulo_id')->references('id')->on('articulos');
            $table->foreignId('caja_id')->references('id')->on('cajas');
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
        Schema::dropIfExists('control_stocks');
    }
}
