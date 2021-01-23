<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserProofsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_proofs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->boolean('type')->comment('1=>age proof, 2=>medical proof');
			$table->text('file_url', 65535);
			$table->string('file_name', 200)->nullable();
			$table->enum('status', array('active','blocked'))->default('active');
			$table->integer('user_id')->unsigned()->index('user_id');
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
		Schema::drop('user_proofs');
	}

}
