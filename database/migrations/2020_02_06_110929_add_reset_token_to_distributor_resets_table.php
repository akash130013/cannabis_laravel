<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResetTokenToDistributorResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distributor_resets', function (Blueprint $table) {
            $table->integer('distributor_id')->unsigned()->after('id');
            $table->string('reset_token', 500)->after('distributor_id');
            $table->foreign('distributor_id')->references('id')->on('distributors');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distributor_resets', function (Blueprint $table) {
            $table->dropForeign('distributor_resets_distributor_id_foreign');
            $table->dropColumn('distributor_id');
            $table->dropColumn('reset_token');
        });
    }
}
