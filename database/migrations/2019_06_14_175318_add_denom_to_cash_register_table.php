<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDenomToCashRegisterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_registers', function (Blueprint $table) {
            $table->integer('denom1000')->nullable()->after('closed_at');
            $table->integer('denom500')->nullable()->after('denom1000');
            $table->integer('denom200')->nullable()->after('denom500');
            $table->integer('denom100')->nullable()->after('denom200');
            $table->integer('denom50')->nullable()->after('denom100');
            $table->integer('denom20')->nullable()->after('denom50');
            $table->integer('denom10')->nullable()->after('denom20');
            $table->integer('denom5')->nullable()->after('denom10');
            $table->integer('denom1')->nullable()->after('denom5');
            $table->integer('denom_25')->nullable()->after('denom1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cash_registers', function (Blueprint $table) {
            //
        });
    }
}
