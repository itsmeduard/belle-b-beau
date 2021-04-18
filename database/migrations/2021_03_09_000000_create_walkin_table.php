<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalkinTable extends Migration
{
    public function up()
    {
        Schema::create('walkin', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('service');
            $table->string('schedule');
            $table->string('address');
            $table->text('note');
            $table->timestamps('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('walkin');
    }
}
