<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //2020_08_31_171133_create_cajas_table
    //2020_08_25_150123_create_cajas_table
    //2020_08_31_171133_create_sessioncajas_table
    //2020_08_25_150123_create_sessioncajas_table
    public function up()
    {
        Schema::create('cajas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20);
            $table->string('fecha', 20);
            $table->string('hora_cierre', 20);
            $table->string('hora', 20);
            $table->string('mes', 20);
            $table->year('year');
            $table->decimal('monto_dolar', 25, 3)->nullable();
            $table->decimal('monto_peso', 25, 3)->nullable();
            $table->decimal('monto_bolivar', 25, 3)->nullable();
            $table->decimal('monto_dolar_cierre', 25, 3)->nullable();
            $table->decimal('monto_peso_cierre', 25, 3)->nullable();
            $table->decimal('monto_bolivar_cierre', 25, 3)->nullable();
            $table->decimal('monto_punto_cierre', 25, 3)->nullable();
            $table->decimal('monto_trans_cierre', 25, 3)->nullable();
            $table->decimal('monto_dolar_cierre_dif', 25, 3)->nullable();
            $table->decimal('monto_peso_cierre_dif', 25, 3)->nullable();
            $table->decimal('monto_bolivar_cierre_dif', 25, 3)->nullable();
            $table->decimal('monto_punto_cierre_dif', 25, 3)->nullable();
            $table->decimal('monto_trans_cierre_dif', 25, 3)->nullable();
            $table->decimal('dolar_dolar_operador', 25, 3)->nullable();
            $table->decimal('peso_dolar_operador', 25, 3)->nullable();
            $table->decimal('punto_dolar_operador', 25, 3)->nullable();
            $table->decimal('trans_dolar_operador', 25, 3)->nullable();
            $table->decimal('efectivo_dolar_operador', 25, 3)->nullable();
            $table->decimal('dolar_sistema', 25, 3)->nullable();
            $table->decimal('peso_sistema', 25, 3)->nullable();
            $table->decimal('punto_sistema', 25, 3)->nullable();
            $table->decimal('trans_sistema', 25, 3)->nullable();
            $table->decimal('efectivo_sistema', 25, 3)->nullable();
            $table->decimal('total_sistema_reg', 25, 3)->nullable();
            $table->decimal('total_operador_reg', 25, 3)->nullable();
            $table->decimal('total_diferencia')->nullable();
            $table->text('Observaciones')->nullable();
            $table->enum('estado', ['Abierta', 'Cerrada', 'Auditoria']);
            $table->string('caja', 20);
            $table->decimal('tasaActualVenta', 25, 2)->nullable();
            $table->decimal('margenActualVenta', 25, 2)->nullable();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('sucursal_id')->references('id')->on('sucursals');
            $table->foreignId('sessioncaja_id')->references('id')->on('sessioncajas');
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
        Schema::dropIfExists('cajas');
    }
}
