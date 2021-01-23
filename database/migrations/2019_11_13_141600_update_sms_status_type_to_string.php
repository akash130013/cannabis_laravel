<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSmsStatusTypeToString extends Migration
{
    /**
     * 
     *  up
     * 
     */

    public function up()
    {
        $this->changeColumnType('sms_verifications','status','VARCHAR(20)');
        
    }

    public function changeColumnType($table, $column, $newColumnType) {                
        DB::statement("ALTER TABLE $table CHANGE $column $column $newColumnType DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('string', function (Blueprint $table) {
            //
        });
    }
}
