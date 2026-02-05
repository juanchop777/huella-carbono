<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsumptionRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('hc_consumption_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('productive_unit_id');
            $table->unsignedBigInteger('requested_by');
            $table->date('consumption_date');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();

            $table->foreign('productive_unit_id')->references('id')->on('hc_productive_units')->onDelete('cascade');
            $table->foreign('requested_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('hc_consumption_request_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consumption_request_id');
            $table->unsignedBigInteger('emission_factor_id');
            $table->decimal('quantity', 15, 3);
            $table->decimal('nitrogen_percentage', 5, 2)->nullable();
            $table->timestamps();

            $table->foreign('consumption_request_id')->references('id')->on('hc_consumption_requests')->onDelete('cascade');
            $table->foreign('emission_factor_id')->references('id')->on('hc_emission_factors')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('hc_consumption_request_items');
        Schema::dropIfExists('hc_consumption_requests');
    }
}
