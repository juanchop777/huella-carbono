<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductiveUnitIdToHcProductiveUnitsTable extends Migration
{
    /**
     * Run the migrations.
     * Agregar relación opcional con la tabla productive_units (SICA)
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hc_productive_units', function (Blueprint $table) {
            // Agregar columna para relacionar con productive_units de SICA (opcional)
            $table->unsignedBigInteger('productive_unit_id')->nullable()->after('id');
            
            // Foreign key con onDelete cascade
            $table->foreign('productive_unit_id')
                  ->references('id')
                  ->on('productive_units')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hc_productive_units', function (Blueprint $table) {
            // Eliminar foreign key primero
            $table->dropForeign(['productive_unit_id']);
            // Luego eliminar columna
            $table->dropColumn('productive_unit_id');
        });
    }
}
