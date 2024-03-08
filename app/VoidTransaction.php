<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoidTransaction extends Model
{
    protected $fillable = [
    	'business_id', 'location_id', 'type', 'status', 'payment_status', 'contact_id', 'invoice_no', 'ref_no', 'transaction_date', 'total_before_tax', 'tax_id', 'tax_amount', 'discount_type', 'discount_amount', 'shipping_details', 'shipping_charges', 'additional_notes', 'staff_note', 'final_total', 'ip_address', 'mac_address', 'exchange_rate', 'document', 'is_direct_sale', 'adjustment_type', 'total_amount_recovered', 'commission_agent', 'res_table_id', 'res_waiter_id', 'res_order_status', 'selling_price_group_id', 'pay_term_number', 'pay_term_type', 'is_suspend', 'is_recurring', 'recur_interval', 'recur_interval_type', 'recur_repetitions', 'recur_stopped_on', 'recur_parent_id', 'subscription_no', 'order_addresses', 'sub_type', 'is_quotation', 'customer_group_id', 'expense_category_id', 'expense_for', 'transfer_parent_id', 'return_parent_id', 'opening_stock_product_id', 'invoice_token', 'created_by', 'created_at', 'updated_at'
    ];
}
