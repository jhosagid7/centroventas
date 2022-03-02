<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('num_documento',20);
            $table->decimal('deuda', 25, 3);
            $table->text('observaciones')->nullable();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('categoria_pago_id')->references('id')->on('categoria_pagos');
            $table->foreignId('tipo_pago_id')->references('id')->on('tipo_pagos');
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
        Schema::dropIfExists('servicios');
    }
}
