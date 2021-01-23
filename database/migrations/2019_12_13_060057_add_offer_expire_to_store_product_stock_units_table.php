<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOfferExpireToStoreProductStockUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_product_stock_units', function (Blueprint $table) {
            
            $table->date('offer_end')->nullable(True)->after('status');
            //
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
            $table->dropColumn('offer_end');
        });
    }
}
