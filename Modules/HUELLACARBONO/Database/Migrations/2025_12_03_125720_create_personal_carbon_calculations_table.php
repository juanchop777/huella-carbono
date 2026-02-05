<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalCarbonCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hc_personal_carbon_calculations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // Nombre del visitante (opcional)
            $table->string('email')->nullable(); // Email (opcional)
            $table->decimal('water_consumption', 10, 3)->default(0); // Litros
            $table->decimal('energy_consumption', 10, 3)->default(0); // Kw/h
            $table->decimal('gasoline_consumption', 10, 3)->default(0); // galones
            $table->decimal('diesel_consumption', 10, 3)->default(0); // galones ACPM
            $table->decimal('waste_generation', 10, 3)->default(0); // Kg
            $table->integer('number_of_animals')->default(0); // Cantidad
            $table->decimal('synthetic_fertilizers', 10, 3)->default(0); // Kg
            $table->decimal('fertilizer_nitrogen_percentage', 5, 2)->nullable(); // %
            $table->decimal('insecticides', 10, 3)->default(0); // Kg
            $table->decimal('fungicides', 10, 3)->default(0); // Kg
            $table->decimal('herbicides', 10, 3)->default(0); // Kg
            $table->decimal('total_co2', 10, 3); // Total CO2 generado
            $table->string('period')->default('monthly'); // monthly, weekly, yearly
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
        Schema::dropIfExists('hc_personal_carbon_calculations');
    }
}
