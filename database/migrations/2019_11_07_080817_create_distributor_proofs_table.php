<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDistributorProofsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('distributor_proofs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('distributor_id')->unsigned();
			$table->enum('type', array('license','valid_proof','other'));
			$table->string('file_url', 500);
			$table->boolean('is_validated')->default(0);
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
		Schema::drop('distributor_proofs');
	}

}
