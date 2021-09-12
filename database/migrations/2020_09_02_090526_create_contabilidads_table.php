<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContabilidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contabilidads', function (Blueprint $table) {
            $table->id();
            $table->string('denominacion', 100);
            $table->decimal('valor', 25, 3);
            $table->unsignedInteger('cantidad')->nullable();
            $table->decimal('subtotal', 25, 3)->nullable();
            $table->string('tipo', 20);
            $table->enum('modo', ['Apertura', 'Cierre']);
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
        Schema::dropIfExists('contabilidads');
    }
}
