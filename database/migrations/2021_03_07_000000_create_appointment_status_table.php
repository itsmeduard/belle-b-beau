<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentStatusTable extends Migration
{
    public function up()
    {
        Schema::create('appointment_status', function (Blueprint $table) {
            $table->id();
            $table->string('appt_id');
            $table->string('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointment_status');
    }
}
