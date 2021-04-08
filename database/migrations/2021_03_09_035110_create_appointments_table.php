<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('service');
            $table->string('schedule');
            $table->text('note');
            $table->string('ip_address');
            $table->timestamps('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
