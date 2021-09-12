<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_operacion',['Cargo','Descargo','Transferencia']);
            $table->enum('tipo_descargo',['Normal','Autoconsumo','Retiro'])->nullable();
            $table->string('deposito', 100);
            $table->string('num_documento', 15);
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('autorizado_por', 100)->nullable();
            $table->string('proposito')->nullable();
            $table->text('detalle')->nullable();
            $table->decimal('total_operacion', 25, 3);
            $table->enum('estado',['Aceptado','Cancelado']);
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
        Schema::dropIfExists('transactions');
    }
}
