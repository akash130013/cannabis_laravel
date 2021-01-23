<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStoreProductStockTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('store_product_stock', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('product_id')->unsigned();
			$table->integer('store_id')->unsigned();
			$table->integer('available_stock')->unsigned();
			$table->integer('total_stock')->unsigned();
			$table->float('min', 10, 0);
			$table->float('max', 10, 0);
			$table->string('price_range', 50)->nullable();
			$table->enum('status', array('active','blocked'))->default('active');
			$table->text('pro_desc', 65535);
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
		Schema::drop('store_product_stock');
	}

}
