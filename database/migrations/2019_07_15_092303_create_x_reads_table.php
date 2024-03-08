<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXReadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_reads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('business_id');
            $table->string('mac_address');
            $table->string('date');
            $table->string('starting_invoice');
            $table->string('ending_invoice');
            $table->string('total_invoices');
            $table->string('success_transactions');
            $table->string('void_transactions');
            $table->string('sales_amout');
            $table->string('vatable_amount');
            $table->string('vat_exempt');
            $table->string('zero_rated');
            $table->string('total_vat');
            $table->string('previous_reading');
            $table->string('current_sales');
            $table->string('running_total');
            $table->string('status');
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
        Schema::dropIfExists('x_reads');
    }
}
