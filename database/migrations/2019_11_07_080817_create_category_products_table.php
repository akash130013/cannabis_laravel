<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category_products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('category_id')->unsigned();
			$table->string('product_name', 150);
			$table->text('quantity_json', 65535);
			$table->text('product_desc', 65535);
			$table->float('thc_per', 10, 0);
			$table->float('cbd_per', 10, 0);
			$table->boolean('is_trending')->default(2);
			$table->enum('status', array('active','blocked','deleted'))->default('active');
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
		Schema::drop('category_products');
	}

}
