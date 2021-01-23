<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToStoreProductStockUnitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('store_product_stock_units', function(Blueprint $table)
		{
			$table->foreign('stock_id', 'store_product_stock_units_ibfk_1')->references('id')->on('store_product_stock')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('store_product_stock_units', function(Blueprint $table)
		{
			$table->dropForeign('store_product_stock_units_ibfk_1');
		});
	}

}
