<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScheduleTimeToDistributorOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distributor_order', function (Blueprint $table) {
            $table->dateTime('schedule_at')->after('order_uid')->comment('maximum delivery date time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('distributor_order', 'schedule_at')){
            Schema::table('distributor_order', function (Blueprint $table) {
                $table->dropColumn('schedule_at');
            });

        }
    }
}
