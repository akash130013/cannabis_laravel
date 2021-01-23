<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToStoreEarningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_earning', function (Blueprint $table) {
            $table->dropColumn('is_scheduled');
            $table->dropColumn('schedule_date');
            $table->dropColumn('order_data');
            $table->unsignedInteger('order_id')->after('id');
            $table->double('commission')->comment("earned commission")->after('net_amount');
            $table->foreign('order_id')->references('id')->on('orders');

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
            $table->boolean('is_scheduled')->default(0);
            $table->date('schedule_date')->nullable();
            $table->text('order_data', 65535)->nullable();
            $table->dropColumn('commission');
            $table->dropForeign('store_earning_store_id_foreign');
            $table->dropForeign('store_earning_order_id_foreign');
        });
    }
}
