<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cajas', function (Blueprint $table) {
            $table->decimal('tasaDolarOpen', 25, 2)->nullable()->after('caja');
            $table->decimal('tasaDolarOpenPorcentajeGanancia', 25, 2)->nullable()->after('tasaDolarOpen');
            $table->decimal('tasaPesoOpen', 25, 2)->nullable()->after('tasaDolarOpenPorcentajeGanancia');
            $table->decimal('tasaPesoOpenPorcentajeGanancia', 25, 2)->nullable()->after('tasaPesoOpen');
            $table->decimal('tasaTransferenciaPuntoOpen', 25, 2)->nullable()->after('tasaPesoOpenPorcentajeGanancia');
            $table->decimal('tasaTransferenciaPuntoOpenPorcentajeGanancia', 25, 2)->nullable()->after('tasaTransferenciaPuntoOpen');
            $table->decimal('tasaEfectivoOpen', 25, 2)->nullable()->after('tasaTransferenciaPuntoOpenPorcentajeGanancia');
            $table->decimal('tasaEfectivoOpenPorcentajeGanancia', 25, 2)->nullable()->after('tasaEfectivoOpen');
            $table->decimal('tasaDolarClose', 25, 2)->nullable()->after('tasaEfectivoOpenPorcentajeGanancia');
            $table->decimal('tasaDolarClosePorcentajeGanancia', 25, 2)->nullable()->after('tasaDolarClose');
            $table->decimal('tasaPesoClose', 25, 2)->nullable()->after('tasaDolarClosePorcentajeGanancia');
            $table->decimal('tasaPesoClosePorcentajeGanancia', 25, 2)->nullable()->after('tasaPesoClose');
            $table->decimal('tasaTransferenciaPuntoClose', 25, 2)->nullable()->after('tasaPesoClosePorcentajeGanancia');
            $table->decimal('tasaTransferenciaPuntoClosePorcentajeGanancia', 25, 2)->nullable()->after('tasaTransferenciaPuntoClose');
            $table->decimal('tasaEfectivoClose', 25, 2)->nullable()->after('tasaTransferenciaPuntoClosePorcentajeGanancia');
            $table->decimal('tasaEfectivoClosePorcentajeGanancia', 25, 2)->nullable()->after('tasaEfectivoClose');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cajas', function (Blueprint $table) {
            $table->dropColumn('tasaDolarOpen');
            $table->dropColumn('tasaDolarOpenPorcentajeGanancia');
            $table->dropColumn('tasaPesoOpen');
            $table->dropColumn('tasaPesoOpenPorcentajeGanancia');
            $table->dropColumn('tasaTransferenciaPuntoOpen');
            $table->dropColumn('tasaTransferenciaPuntoOpenPorcentajeGanancia');
            $table->dropColumn('tasaEfectivoOpen');
            $table->dropColumn('tasaEfectivoOpenPorcentajeGanancia');
            $table->dropColumn('tasaDolarClose');
            $table->dropColumn('tasaDolarClosePorcentajeGanancia');
            $table->dropColumn('tasaPesoClose');
            $table->dropColumn('tasaPesoClosePorcentajeGanancia');
            $table->dropColumn('tasaTransferenciaPuntoClose');
            $table->dropColumn('tasaTransferenciaPuntoClosePorcentajeGanancia');
            $table->dropColumn('tasaEfectivoClose');
            $table->dropColumn('tasaEfectivoClosePorcentajeGanancia');
        });
    }
}
