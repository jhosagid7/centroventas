<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaccionesBancosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transacciones_bancos', function (Blueprint $table) {
            $table->id();
            $table->string('concepto', 250)->nullable();
            $table->string('banco_origen', 20)->nullable();
            $table->string('banco_destiono', 20)->nullable();
            $table->decimal('tasa_destino', 25, 4)->nullable();
            $table->decimal('saldo_banco_dolar', 25, 4)->nullable();
            $table->decimal('saldo_banco_peso', 25, 4)->nullable();
            $table->decimal('saldo_banco_punto', 25, 4)->nullable();
            $table->decimal('saldo_banco_bolivar', 25, 4)->nullable();
            $table->decimal('monto_debitar', 25, 4)->nullable();
            $table->decimal('monto_transferir', 25, 4)->nullable();
            $table->string('operador', 250)->nullable();
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
        Schema::dropIfExists('transacciones_bancos');
    }
}
