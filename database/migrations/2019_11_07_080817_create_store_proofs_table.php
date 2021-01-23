<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStoreProofsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('store_proofs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('fileurl', 65535);
			$table->integer('store_id')->unsigned();
			$table->enum('status', array('active','block'))->default('active');
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
		Schema::drop('store_proofs');
	}

}
