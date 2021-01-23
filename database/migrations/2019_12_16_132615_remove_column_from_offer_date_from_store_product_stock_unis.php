<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColumnFromOfferDateFromStoreProductStockUnis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_product_stock_units', function (Blueprint $table) {
            $table->dropColumn('offer_start');
            $table->dropColumn('offer_end');
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
            $table->date('offer_start');
            $table->date('offer_end');
        });
    }
}
