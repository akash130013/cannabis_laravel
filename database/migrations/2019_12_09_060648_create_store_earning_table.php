<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreEarningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_earning', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_uid', 191);
			$table->bigInteger('store_id')->unsigned();
			$table->float('net_amount', 10, 0)->nullable();
			$table->enum('payment_method', array('COD'))->default('COD');
			$table->boolean('is_scheduled')->default(0);
			$table->date('schedule_date')->nullable();
			$table->text('order_data', 65535)->nullable();
			$table->enum('status', array('open','closed'))->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_earning');
    }
}
