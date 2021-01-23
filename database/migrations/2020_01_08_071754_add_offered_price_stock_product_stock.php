<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOfferedPriceStockProductStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_product_stock_units', function (Blueprint $table) {
            $table->boolean('is_timely_offered')->default(false)->nullable()->after('actual_price');
            $table->float('timely_offered_price')->nullable()->after('is_timely_offered');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_product_stock_units', function (Blueprint $table) {
            //
        });
        
    }
}
