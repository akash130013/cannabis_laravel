<?php

use Illuminate\Database\Seeder;

class ProductReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = $this->confirmData();
        $number = $this->confirmSize();
        $this->command->info($number);

        factory(\App\Models\Rating::class, $number)->create(['type' => $type]);
    }

    protected function confirmData()
    {
        $type = $this->command->ask("type: product, store or driver");
        if (!in_array($type, ['product', 'store', 'driver'])){
            $this->command->info("enter only product, store or driver");
            $this->confirmData();
        }
        return $type;
    }
    protected function confirmSize() {
        $number = (int) $this->command->ask('how much data you want to generate ? default 10');
        $this->command->info(gettype($number));
        if (empty($number)) {
            $number = 10;
        }
        if (!is_int($number)){
            $this->command->info("enter only in numeric format 1 100 1000 without decimal");
            $this->confirmSize();
        }

        return $number;
    }
}
