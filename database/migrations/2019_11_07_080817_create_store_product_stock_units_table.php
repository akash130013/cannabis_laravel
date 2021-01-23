<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStoreProductStockUnitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('store_product_stock_units', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('stock_id')->unsigned()->index('stock_id');
			$table->string('unit', 10);
			$table->integer('quant_unit')->unsigned();
			$table->float('price', 10, 0)->comment('price is the final selling price of the product ');
			$table->float('offered_price', 10, 0)->nullable();
			$table->float('actual_price', 10, 0);
			$table->integer('total_stock')->unsigned();
			$table->enum('status', array('active','block'))->default('active');
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
		Schema::drop('store_product_stock_units');
	}

}
