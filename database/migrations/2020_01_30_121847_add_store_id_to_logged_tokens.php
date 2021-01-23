<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStoreIdToLoggedTokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logged_tokens', function (Blueprint $table) {
            $table->unsignedInteger('store_id')->nullable();
            $table->string('order_uid')->nullable();
            $table->foreign('store_id')->references('id')->on('store');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('logged_tokens', function (Blueprint $table) {
            $table->dropForeign('logged_tokens_store_id_foreign');
            $table->dropColumn('store_id');
            $table->dropColumn('order_uid');
        });
    }
}
