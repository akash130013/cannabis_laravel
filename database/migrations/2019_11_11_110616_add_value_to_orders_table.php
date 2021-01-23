<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class AddValueToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `orders` MODIFY order_status  ENUM('init','checkout','order_confirmed','order_placed','order_verified','driver_assigned','on_delivery','delivered','amount_received','order_cancelled','amount_refund_init','amount_refunded')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE orders MODIFY order_status ENUM('init','checkout','order_confirmed','order_placed','order_verified','on_delivery','delivered','amount_received','order_cancelled','amount_refund_init','amount_refunded')");
    }
}
