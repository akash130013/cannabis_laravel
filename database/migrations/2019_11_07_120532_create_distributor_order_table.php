<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistributorOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distributor_order', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('distributor_id');
            $table->unsignedInteger('order_id');
            $table->string('order_uid');
            $table->string('sub_order_uid')->nullable();
            $table->timestamps();
            $table->foreign('distributor_id')->references('id')->on('distributors');
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
        Schema::dropIfExists('distributor_order');
    }
}
