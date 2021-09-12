<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',20);
            $table->decimal('tasa', 25, 2)->default(0.00);
            $table->decimal('porcentaje_ganancia', 25, 2)->default(0.00);
            $table->enum('estado', ['Activo', 'Cancelado', 'Suspendido']);
            $table->enum('caja', ['Abierta', 'Cerrada']);
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
        Schema::dropIfExists('tasas');
    }
}
