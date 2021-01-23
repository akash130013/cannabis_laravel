<?php

use Illuminate\Database\Seeder;

class SiteConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('site_configs')->truncate();
       $data= [
            ['key'=> 'REFERRAL_LOYALTY_CONVERSION_RATE', 'value'=> '1',     'label'=> NULL, 'status'=> 'active'],
            ['key'=> 'PURCHASE_LOYALTY_CONVERSION_RATE', 'value'=> '1.2',   'label'=> NULL, 'status'=> 'active'],
            ['key'=> '1',                                'value'=> '1',     'label'=> 1,    'status'=> 'active'],
            ['key'=> '10',                               'value'=>'15',     'label'=> 1,    'status'=> 'active']
        ];
        DB::table('site_configs')->insert($data);
        
    }
}
