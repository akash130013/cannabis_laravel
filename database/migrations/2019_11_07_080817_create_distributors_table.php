<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDistributorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('distributors', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);
			$table->enum('gender', array('Male','Female','Other'))->default('Male');
			$table->string('country_code', 10);
			$table->string('phone_number', 25);
			$table->dateTime('phone_number_verified_at')->nullable();
			$table->string('password', 191);
			$table->string('remember_token', 191);
			$table->string('email', 191)->nullable();
			$table->string('profile_image', 500)->nullable();
			$table->text('address', 65535)->nullable();
			$table->string('city', 191)->nullable();
			$table->string('state', 191)->nullable();
			$table->string('zipcode', 10)->nullable();
			$table->float('latitude', 10, 0)->nullable();
			$table->float('longitude', 10, 0)->nullable();
			$table->string('dl_number', 191)->comment('driver license number');
			$table->date('dl_expiraion_date');
			$table->string('vehicle_number', 191);
			$table->text('vehicle_images', 65535);
			$table->enum('status', array('verification_pending','active','blocked'));
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
		Schema::drop('distributors');
	}

}
