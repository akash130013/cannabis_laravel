<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStoreDeliveryLocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('store_delivery_locations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('formatted_address', 65535);
			$table->integer('store_id')->unsigned();
			$table->float('lat', 10, 0);
			$table->float('lng', 10, 0);
			$table->integer('zip_code')->unsigned()->nullable();
			$table->enum('status', array('active','blocked'))->default('active');
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
		Schema::drop('store_delivery_locations');
	}

}
