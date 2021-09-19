<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagoVueltosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_vueltos', function (Blueprint $table) {
            $table->id();
            $table->enum('Tipo', ['Consumo','Creditos'])->nullable();
            $table->enum('tipo_vuelto', ['Vueltos_Pagos', 'Vueltos_Excedentes'])->nullable();
            $table->string('Divisa', 20)->nullable();
            $table->decimal('MontoDivisa', 25, 8)->nullable();
            $table->decimal('TasaTiket', 25, 2)->nullable();
            $table->decimal('MontoDolar', 25, 8)->nullable();
            $table->foreignId('venta_id')->references('id')->on('ventas')->default(0)->nullable();
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
        Schema::dropIfExists('pago_vueltos');
    }
}
