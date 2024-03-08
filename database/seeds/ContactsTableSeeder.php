<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Contact;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::create([
            'id'=>2,
            'business_id'=>1,
            'type'=>'customer',
            'supplier_business_name'=>null,
            'name'=>'Senior Citizen',
            'email'=>null,
            'contact_id'=>'CO0002',
            'tax_number'=>null,
            'city'=>null,
            'state'=>null,
            'country'=>null,
            'landmark'=>null,
            'mobile'=>'09123456789',
            'landline'=>null,
            'alternate_number'=>null,
            'pay_term_number'=>null,
            'pay_term_type'=>null,
            'credit_limit'=>null,
            'created_by'=>1,
            'is_default'=>0,
            'customer_group_id'=>null,
            'custom_field1'=>null,
            'custom_field2'=>null,
            'custom_field3'=>null,
            'custom_field4'=>null,
            'created_at'=>'2019-07-20 11:00:00',
            'updated_at'=>'2019-07-20 11:00:00'
        ]);
    }
}
