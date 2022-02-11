<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->enum('tipo_pago_condicion', ['Contado','Credito'])->after('estado');
            $table->enum('status', ['Pagado','Pendiente'])->after('tipo_pago_condicion');
        });
    }

    /**
     * Reverse the migrationss.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropColumn('tipo_pago_condicion');
            $table->dropColumn('status');
        });
    }
}
