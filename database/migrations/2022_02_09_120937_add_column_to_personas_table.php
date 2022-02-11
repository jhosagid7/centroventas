<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->unsignedInteger('isCortesia')->nullable()->after('email');
            $table->unsignedInteger('isCredito')->nullable()->after('isCortesia');
            $table->integer('limite_fecha')->nullable()->after('imagen');
            $table->decimal('limite_monto', 25, 2)->nullable()->after('limite_fecha');
        });
    }

    /**
     * Reverse the migrationss.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->dropColumn('isCortesia');
            $table->dropColumn('isCredito');
            $table->dropColumn('limite_fecha');
            $table->dropColumn('limite_monto');
        });
    }
}
