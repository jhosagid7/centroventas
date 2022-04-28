<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialCreditoCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_credito_cajas', function (Blueprint $table) {
            $table->id();
            $table->integer('hist_creditos_vigentes')->nullable()->default(0);
            $table->integer('hist_creditos_vencidos')->nullable()->default(0);
            $table->integer('hist_creditos_pagados')->nullable()->default(0);
            $table->integer('hist_creditos_nuevos')->nullable()->default(0);
            $table->integer('hist_total_creditos')->nullable()->default(0);
            $table->foreignId('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('historial_credito_cajas');
    }
}
