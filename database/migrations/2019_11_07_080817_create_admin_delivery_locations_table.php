<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminDeliveryLocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_delivery_locations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('address', 65535)->nullable();
			$table->string('city', 50)->nullable();
			$table->string('state', 50)->nullable();
			$table->integer('zipcode')->unsigned();
			$table->string('country', 50)->nullable();
			$table->string('timezone', 50)->nullable();
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
		Schema::drop('admin_delivery_locations');
	}

}
