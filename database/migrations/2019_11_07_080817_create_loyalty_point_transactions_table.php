<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLoyaltyPointTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('loyalty_point_transactions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('user_id')->unsigned();
			$table->float('last_amount', 10, 0);
			$table->enum('operation', array('credit','debit'));
			$table->float('operated_amount', 10, 0);
			$table->float('net_amount', 10, 0);
			$table->enum('reason', array('referred','purchase','discounted','other'));
			$table->text('remark', 65535);
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
		Schema::drop('loyalty_point_transactions');
	}

}
