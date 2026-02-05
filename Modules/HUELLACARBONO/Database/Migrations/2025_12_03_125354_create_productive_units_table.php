<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductiveUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hc_productive_units', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre de la unidad productiva
            $table->string('code')->unique(); // Código único
            $table->text('description')->nullable();
            $table->unsignedBigInteger('leader_user_id')->nullable(); // ID del líder de la unidad
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->foreign('leader_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hc_productive_units');
    }
}
