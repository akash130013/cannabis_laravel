<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressTypeToUserDeliveryLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_delivery_location', function (Blueprint $table) {
            $table->enum('address_type', ['home', 'office', 'other'])->after('country')->default('other');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_delivery_location', function (Blueprint $table) {
            $table->dropColumn('address_type');
        });
    }
}
