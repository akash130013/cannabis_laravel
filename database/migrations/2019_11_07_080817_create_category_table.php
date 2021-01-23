<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('category_name', 150);
			$table->string('image_url', 200)->nullable();
			$table->enum('status', array('active','blocked','deleted'))->default('active');
			$table->text('category_desc', 65535)->nullable()->comment('description of the category');
			$table->text('thumb_url', 65535)->nullable();
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
		Schema::drop('category');
	}

}
