<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStoreTimingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('store_timing', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('store_id')->unsigned();
			$table->smallInteger('day')->comment('1--> mon,2--->tue,3--->wed,4--->thur,5-->fri,6-->sat,7--->sun');
			$table->time('start_time');
			$table->time('end_time');
			$table->enum('working_status', array('open','closed'));
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
		Schema::drop('store_timing');
	}

}
