<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_comprobante', 20);
            $table->string('serie_comprobante', 20);
            $table->string('num_comprobante', 20);
            $table->enum('tipo_pago', ['Contado', 'Credito']);
            $table->enum('status', ['Pagado', 'Por pagar']);
            $table->decimal('precio_compra', 25, 9)->nullable();
            $table->datetime('fecha_hora');
            $table->enum('estado', ['Aceptado', 'Cancelado', 'Procesando']);
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
        Schema::dropIfExists('ingresos');
    }
}
