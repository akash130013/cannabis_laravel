<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStoreProductRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('store_product_requests', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('store_id')->unsigned()->index('store_id');
			$table->string('product_name', 75);
			$table->integer('thc');
			$table->integer('cbd');
			$table->text('product_desc', 65535);
			$table->enum('status', array('pending','approved','deleted'))->default('pending');
			$table->dateTime('created_at')->nullable();
			$table->integer('updated_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('store_product_requests');
	}

}
