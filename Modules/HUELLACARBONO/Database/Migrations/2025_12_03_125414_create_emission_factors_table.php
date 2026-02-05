<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmissionFactorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hc_emission_factors', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del factor (ej: Consumo de agua)
            $table->string('code')->unique(); // Código único
            $table->string('unit'); // Unidad de medida (L, Kw/h, galón, Kg, Und)
            $table->decimal('factor', 10, 7); // Factor de emisión
            $table->text('description')->nullable();
            $table->boolean('requires_percentage')->default(false); // Para fertilizantes que requieren % nitrógeno
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0); // Orden de visualización
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
        Schema::dropIfExists('hc_emission_factors');
    }
}
