<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeniorToTranactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('void_transactions', function (Blueprint $table) {
            $table->string('s_id')->nullable()->after('staff_note');
            $table->string('s_name')->nullable()->after('s_id');
            $table->string('s_addr')->nullable()->after('s_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('void_transactions', function (Blueprint $table) {
            //
        });
    }
}
