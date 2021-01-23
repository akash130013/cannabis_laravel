<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('order_uid', 191);
			$table->bigInteger('user_id')->unsigned();
			$table->text('delivery_address', 65535)->nullable();
			$table->float('cart_subtotal', 10, 0)->nullable();
			$table->string('promo_code', 191)->nullable();
			$table->text('additional_charges')->nullable();
			$table->text('discounts')->nullable();
			$table->float('net_amount', 10, 0)->nullable();
			$table->enum('payment_method', array('COD'))->default('COD');
			$table->boolean('is_scheduled')->default(0);
			$table->date('schedule_date')->nullable();
			$table->text('order_data', 65535)->nullable();
			$table->enum('order_status', array('init','checkout','order_confirmed','order_placed','order_verified','on_delivery','delivered','amount_received','order_cancelled','amount_refund_init','amount_refunded'))->default('init');
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
		Schema::drop('orders');
	}

}
