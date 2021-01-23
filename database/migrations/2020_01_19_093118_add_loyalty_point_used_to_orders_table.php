<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class AddLoyaltyPointUsedToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('loyalty_point_used')->nullable()->after('promo_code')->comment('loyalty points that being used for loyalty_point discount in discount column');
        });
        DB::statement("ALTER TABLE `loyalty_point_transactions` CHANGE `reason` `reason` ENUM('referred','purchase','discounted','refunded', 'other') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('loyalty_point_used');
        });
        DB::statement("ALTER TABLE `loyalty_point_transactions` CHANGE `reason` `reason` ENUM('referred','purchase','discounted', 'other') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL");
    }
}
