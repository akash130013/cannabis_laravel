<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToStoreEarningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_earning', function (Blueprint $table) {
            $table->dropColumn('net_amount');
            $table->double('amount_received')->after('store_id')->comment('net_amount from order table');
            $table->double('actual_amount')->after('store_id')->comment('cart_subtotal from order table');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_earning', function (Blueprint $table) {
            $table->dropColumn('amount_received');
            $table->dropColumn('actual_amount');
            $table->double('net_amount')->after('store_id');
        });
    }
}
