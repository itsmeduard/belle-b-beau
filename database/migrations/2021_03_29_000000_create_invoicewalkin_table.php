<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateInvoiceWalkinTable extends Migration
{
    public function up()
    {
        Schema::create('invoice_walkin', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->string('detail_id');
            $table->string('total');
            $table->timestamps('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoice_walkin');
    }
}
