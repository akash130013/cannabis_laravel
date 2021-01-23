<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStoreDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('store_details', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('store_name', 150);
			$table->string('contact_number', 20);
			$table->text('formatted_address', 65535);
			$table->integer('store_id')->unsigned();
			$table->text('about_store', 65535);
			$table->float('lat', 10, 0);
			$table->float('lng', 10, 0);
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
		Schema::drop('store_details');
	}

}
