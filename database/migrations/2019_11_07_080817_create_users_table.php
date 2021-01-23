<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);
			$table->string('user_referral_code', 8)->nullable()->unique('user_referral_code')->comment('current user referral code');
			$table->date('dob');
			$table->string('profile_pic', 500)->nullable();
			$table->string('personal_address', 250)->nullable();
			$table->float('lat', 10, 0)->nullable();
			$table->float('lng', 10, 0)->nullable();
			$table->string('country_code', 225);
			$table->string('phone_number', 25);
			$table->dateTime('phone_number_verified_at')->nullable();
			$table->string('email', 191);
			$table->dateTime('email_verified_at')->nullable();
			$table->boolean('is_profile_complete')->default(0);
			$table->boolean('is_proof_completed')->default(0)->comment('1=>YES 0=>NO');
			$table->dateTime('location_updated_at')->nullable();
			$table->string('password', 191);
			$table->string('remember_token', 100)->nullable();
			$table->text('email_verified_token', 65535);
			$table->enum('status', array('active','blocked'))->default('active');
			$table->string('referred_by', 191)->nullable()->comment('referred by');
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
		Schema::drop('users');
	}

}
