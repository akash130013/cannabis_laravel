<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_details', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('address', 200);
			$table->text('formatted_address', 65535);
			$table->integer('user_id')->unsigned();
			$table->string('country', 75)->nullable();
			$table->string('state', 75)->nullable();
			$table->string('city', 75)->nullable();
			$table->string('zipcode', 20)->nullable();
			$table->float('lat', 10, 0);
			$table->float('lng', 10, 0);
			$table->string('ip', 75)->nullable();
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
		Schema::drop('user_details');
	}

}
