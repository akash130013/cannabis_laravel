<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCartsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('carts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('cart_uid', 191)->nullable()->unique('carts_slug_id_uindex')->comment('uuid');
			$table->string('order_uid', 225)->nullable();
			$table->bigInteger('user_id')->nullable();
			$table->bigInteger('product_id');
			$table->bigInteger('store_id');
			$table->integer('quantity')->unsigned();
			$table->string('size', 191)->comment('size/weight/volume whichever is applicable');
			$table->string('size_unit', 191)->comment('g, mg, ml etc.');
			$table->string('attributes', 191)->nullable();
			$table->integer('selling_price')->unsigned();
			$table->text('order_json', 65535);
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
		Schema::drop('carts');
	}

}
