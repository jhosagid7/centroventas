<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->references('id')->on('categorias');
            $table->string('codigo', 50);
            $table->string('nombre', 100);
            $table->string('stock', 20);
            $table->decimal('precio_costo', 25, 9)->nullable();
            $table->decimal('porEspecial', 25, 2)->nullable();
            $table->unsignedInteger('isDolar')->nullable();
            $table->unsignedInteger('isPeso')->nullable();
            $table->unsignedInteger('isTransPunto')->nullable();
            $table->unsignedInteger('isMixto')->nullable();
            $table->unsignedInteger('isEfectivo')->nullable();
            $table->unsignedInteger('isKilo')->nullable();
            $table->text('descripcion');
            $table->unsignedInteger('unidades')->nullable();
            $table->enum('vender_al', ['Mayor', 'Detal']);
            $table->string('imagen', 200);
            $table->enum('estado', ['Activo', 'Inactivo', 'Eliminado']);
            $table->timestamps();
        });
    }

    /**
     *
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulos');
    }
}
