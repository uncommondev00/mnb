<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoidTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('void_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_id')->unsigned();
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');

            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')->references('id')->on('business_locations');

            $table->enum('type', ['purchase', 'sell']);
            $table->enum('status', ['received', 'pending', 'ordered', 'draft', 'final']);
            $table->enum('payment_status', ['paid', 'due', 'void']);
            $table->integer('contact_id')->unsigned();
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->string('invoice_no')->nullable();
            $table->string('ref_no')->nullable();
            $table->dateTime('transaction_date');
            $table->decimal('total_before_tax', 8, 2)->default(0)->comment('Total before the purchase/invoice tax, this includeds the indivisual product tax');
            $table->integer('tax_id')->unsigned()->nullable();
            $table->foreign('tax_id')->references('id')->on('tax_rates')->onDelete('cascade');
            $table->decimal('tax_amount', 8, 2)->default(0);
            $table->enum('discount_type', ['fixed', 'percentage'])->nullable();
            $table->string('discount_amount', 10)->nullable();
            $table->string('shipping_details')->nullable();
            $table->decimal('shipping_charges', 8, 2)->default(0);
            $table->text('additional_notes')->nullable();
            $table->text('staff_note')->nullable();
            $table->decimal('final_total', 8, 2)->default(0);

            $table->string('ip_address');
            $table->string('mac_address');
            $table->decimal('exchange_rate', 8, 3)->default(1);
            $table->string('document')->nullable();
            $table->boolean('is_direct_sale')->default(0);
            $table->enum('adjustment_type', ['normal', 'abnormal'])->nullable();
            $table->decimal('total_amount_recovered', 20, 2)->comment("Used for stock adjustment.")->nullable();
            $table->integer('commission_agent')->nullable();
            $table->integer('res_table_id')->unsigned()->nullable();
            $table->integer('res_waiter_id')->unsigned()->nullable();
            $table->enum('res_order_status', ['received', 'cooked', 'served'])->nullable();
            $table->integer('selling_price_group_id')->nullable();
            $table->integer('pay_term_number')->nullable();
            $table->enum('pay_term_type', ['days', 'months'])->nullable();
            $table->boolean('is_suspend')->default(0);
            $table->boolean('is_recurring')->default(0);
            $table->float('recur_interval', 8, 2)->nullable();
            $table->enum('recur_interval_type', ['days', 'months', 'years'])->nullable();
            $table->integer('recur_repetitions')->nullable();
            $table->dateTime('recur_stopped_on')->nullable();
            $table->integer('recur_parent_id')->nullable();
            $table->string('subscription_no')->nullable();
            $table->text('order_addresses')->nullable();
            $table->string('sub_type', 20)->nullable();

            $table->boolean('is_quotation');
            $table->integer('customer_group_id')->comment("used to add customer group while selling")->nullable();
            $table->integer('expense_category_id')->nullable()->unsigned();
            $table->foreign('expense_category_id')->references('id')->on('expense_categories')->onDelete('cascade');
            $table->integer('expense_for')->nullable()->unsigned();
            $table->foreign('expense_for')->references('id')->on('users')->onDelete('cascade');
            $table->integer('transfer_parent_id')->nullable();
            $table->integer('return_parent_id')->nullable();
            $table->integer('opening_stock_product_id')->nullable();
            $table->string('invoice_token')->nullable();

            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();

            //Indexing
            $table->index('business_id');
            $table->index('type');
            $table->index('contact_id');
            $table->index('transaction_date');
            $table->index('created_by');
            $table->index('sub_type');
            $table->index('expense_category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('void_transactions');
    }
}
