<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeScheduleAtToDistributorOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distributor_order', function (Blueprint $table) {
            $table->dropColumn('schedule_at');
            $table->date('schedule_date')->after('order_uid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distributor_order', function (Blueprint $table) {
            $table->dropColumn('schedule_date');
        });
    }
}
