<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSmsVerificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sms_verifications', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('country_code', 191);
			$table->string('phone_number', 191);
			$table->char('code', 4);
			$table->enum('status', array('pending','verified'))->default('pending');
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
		Schema::drop('sms_verifications');
	}

}
