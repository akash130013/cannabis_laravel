<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class LicenceToNullableDistributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::statement("ALTER TABLE `distributors` CHANGE `dl_expiraion_date` `dl_expiraion_date` DATE NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `distributors` CHANGE `dl_expiraion_date` `dl_expiraion_date` DATE");

    }
}
