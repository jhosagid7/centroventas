<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedorCreditosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedor_creditos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_cliente', 100)->nullable();
            $table->string('cedula_cliente', 20)->nullable();
            $table->string('direccion_cliente', 100)->nullable();
            $table->string('telefono_cliente', 20)->nullable();
            $table->integer('total_factura')->nullable();
            $table->decimal('total_deuda', 25, 8)->nullable();
            $table->date('fecha_limite_pago')->nullable();
            $table->enum('estado_credito', ['Activo', 'Moroso']);
            $table->foreignId('persona_id')->references('id')->on('personas');
            $table->foreignId('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('proveedor_creditos');
    }
}
