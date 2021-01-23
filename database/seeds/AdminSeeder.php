<?php

use Illuminate\Database\Seeder;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('admins')->truncate();

        $data = [
            ["name" => "Cannabis Admin" , "email" => 'cannabis@gmail.com'  , 'password' => '$2y$10$AYypgzn0nxnXGol88GIImuGgX4oCM2fPqZ78hJTdbDJpbsCwzXdWW']
        ];
        DB::table('admins')->insert($data);

    }
}
