<?php

use App\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker;

class StoreCreateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for($i = 0; $i < 1000; $i++) {
            
	        Store::create([
                'name' => $faker->name,
                'last_name' => $faker->lastName,
                'avatar' =>url('/'),
                'phone' => $faker->phoneNumber,
                'business_name' => $faker->name,
                'licence_number' => $faker->numberBetween(10,20000),
                'email' => $faker->email,
	            'password' => bcrypt('secret'),
	        ]);
        
            }
      //  $users = factory(App\Store::class, 1000)->make();
    }   
        
}
