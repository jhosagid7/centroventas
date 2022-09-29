<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComandasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comandas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_comprobante', 20);
            $table->string('serie_comprobante', 20);
            $table->string('num_comprobante', 20);
            $table->datetime('fecha_hora');
            $table->string('tipo_pago', 20);
            $table->decimal('tasaDolar', 25, 2)->nullable();
            $table->decimal('porDolar', 25, 2)->nullable();
            $table->decimal('tasaPeso', 25, 2)->nullable();
            $table->decimal('porPeso', 25, 2)->nullable();
            $table->decimal('tasaTransPunto', 25, 2)->nullable();
            $table->decimal('porTransPunto', 25, 2)->nullable();
            $table->decimal('tasaMixto', 25, 2)->nullable();
            $table->decimal('porMixto', 25, 2)->nullable();
            $table->decimal('tasaEfectivo', 25, 2)->nullable();
            $table->decimal('porEfectivo', 25, 2)->nullable();
            $table->string('num_Punto', 20)->nullable();
            $table->string('num_Trans', 20)->nullable();
            $table->decimal('precio_costo', 25, 9)->nullable();
            $table->decimal('margen_ganancia', 25, 2)->nullable();
            $table->decimal('total_venta', 25, 3)->nullable();
            $table->decimal('ganancia_neta', 25, 3)->nullable();
            $table->enum('estado', ['Aceptada', 'Cancelada', 'Procesando']);
            $table->foreignId('persona_id')->references('id')->on('personas');
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
        Schema::dropIfExists('comandas');
    }
}
