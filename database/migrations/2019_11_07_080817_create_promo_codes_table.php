<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePromoCodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('promo_codes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('promo_name', 191);
			$table->text('description', 65535)->nullable();
			$table->string('coupon_code', 20);
			$table->enum('promotional_type', array('fixed','percentage'));
			$table->float('amount', 10, 0);
			$table->float('max_cap', 10, 0);
			$table->integer('total_coupon');
			$table->integer('max_redemption_per_user');
			$table->integer('coupon_remained');
			$table->dateTime('start_time');
			$table->dateTime('end_time')->nullable();
			$table->enum('offer_status', array('active','inactive'));
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
		Schema::drop('promo_codes');
	}

}
