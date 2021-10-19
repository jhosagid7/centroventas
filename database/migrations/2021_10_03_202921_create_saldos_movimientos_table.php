<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaldosMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saldos_movimientos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('correlativo');
            $table->decimal('debe', 25, 3)->nullable();
            $table->decimal('haber', 25, 3)->nullable();
            $table->decimal('saldo', 25, 3)->nullable();
            $table->foreignId('cuenta_id')->references('id')->on('cuentas');
            $table->foreignId('transaccion_id')->references('id')->on('transaccions');
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
        Schema::dropIfExists('saldos_movimientos');
    }
}
