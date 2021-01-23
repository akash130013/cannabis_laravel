<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserDeliveryLocationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_delivery_location', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('name', 500);
			$table->string('mobile', 15);
			$table->string('address', 75)->nullable();
			$table->string('formatted_address');
			$table->string('city', 50)->nullable();
			$table->string('state', 50)->nullable();
			$table->integer('zipcode')->unsigned();
			$table->string('country', 50);
			$table->float('lat', 10, 0);
			$table->float('lng', 10, 0);
			$table->boolean('is_default')->default(0)->comment('0---> not a default address,1--> default address');
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
		Schema::drop('user_delivery_location');
	}

}
