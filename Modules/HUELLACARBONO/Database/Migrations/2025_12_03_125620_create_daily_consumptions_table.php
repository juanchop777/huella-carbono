<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyConsumptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hc_daily_consumptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('productive_unit_id');
            $table->unsignedBigInteger('emission_factor_id');
            $table->unsignedBigInteger('registered_by'); // Usuario que registra
            $table->date('consumption_date'); // Fecha del consumo
            $table->decimal('quantity', 10, 3); // Cantidad consumida
            $table->decimal('nitrogen_percentage', 5, 2)->nullable(); // % Nitrógeno para fertilizantes
            $table->decimal('co2_generated', 10, 3); // CO2 generado (calculado)
            $table->text('observations')->nullable();
            $table->timestamps();
            
            $table->foreign('productive_unit_id')->references('id')->on('hc_productive_units')->onDelete('cascade');
            $table->foreign('emission_factor_id')->references('id')->on('hc_emission_factors')->onDelete('cascade');
            $table->foreign('registered_by')->references('id')->on('users')->onDelete('cascade');
            
            // Índice para búsquedas rápidas por fecha y unidad
            $table->index(['productive_unit_id', 'consumption_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hc_daily_consumptions');
    }
}
