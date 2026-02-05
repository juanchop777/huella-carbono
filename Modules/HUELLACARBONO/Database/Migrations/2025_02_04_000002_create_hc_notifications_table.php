<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHcNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('hc_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('type', 64); // request_approved, request_rejected
            $table->string('title');
            $table->text('body')->nullable();
            $table->json('data')->nullable(); // consumption_request_id, consumption_date, etc.
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'read_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('hc_notifications');
    }
}
