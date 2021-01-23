<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['driver', 'store', 'product']);
            $table->unsignedBigInteger('rated_id');
            $table->unsignedInteger('rate');
            $table->longText('review');
            $table->json('images')->nullable();
            $table->unsignedInteger('created_by')->comment('user_id');
            $table->unsignedInteger('order_id');
            $table->string('order_uid');
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
        Schema::dropIfExists('ratings');
    }
}
