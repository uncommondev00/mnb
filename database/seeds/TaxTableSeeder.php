<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\TaxRate;

class TaxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaxRate::create([
            'id'=>1,
            'business_id'=>1,
            'name'=>'VAT@12%',
            'amount'=>12.00,
            'is_tax_group'=>0,
            'created_by'=>1,
            'created_at'=>'2019-07-20 11:00:00',
            'updated_at'=>'2019-07-20 11:00:00'
        ]);
            
       TaxRate::create([
            'id'=>2,
            'business_id'=>1,
            'name'=>'VAT EXEMPT',
            'amount'=>0.00,
            'is_tax_group'=>0,
            'created_by'=>1,
            'created_at'=>'2019-07-20 11:00:00',
            'updated_at'=>'2019-07-20 11:00:00'
        ]);
            
        TaxRate::create([
            'id'=>3,
            'business_id'=>1,
            'name'=>'ZERO RATED',
            'amount'=>0.00,
            'is_tax_group'=>0,
            'created_by'=>1,
            'created_at'=>'2019-07-20 11:00:00',
            'updated_at'=>'2019-07-20 11:00:00'
        ]);
                

    }
}
