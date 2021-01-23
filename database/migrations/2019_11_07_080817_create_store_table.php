<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStoreTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('store', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191)->nullable();
			$table->string('last_name', 191)->nullable();
			$table->text('avatar')->nullable();
			$table->string('email', 191)->unique();
			$table->string('phone', 20)->nullable();
			$table->boolean('is_profile_complete')->default(0)->comment('0-->not completed, 1---> completed');
			$table->string('business_name', 150)->nullable();
			$table->string('licence_number', 50)->nullable();
			$table->string('password', 191);
			$table->enum('is_email_verified', array('verified','unverified'))->default('unverified');
			$table->enum('is_mobile_verified', array('verified','unverified'))->default('unverified');
			$table->enum('status', array('active','blocked'))->default('active');
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('store');
	}

}
