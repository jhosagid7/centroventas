<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagoCreditosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_creditos', function (Blueprint $table) {
            $table->id();
            $table->string('Divisa', 20)->nullable();
            $table->decimal('MontoDivisa', 25, 3)->nullable();
            $table->decimal('TasaTiket', 25, 2)->nullable();
            $table->decimal('MontoDolar', 25, 3)->nullable();
            $table->decimal('Vueltos', 25, 3)->nullable();
            $table->foreignId('venta_id')->references('id')->on('ventas');
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
        Schema::dropIfExists('pago_creditos');
    }
}
