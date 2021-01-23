<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToUserNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::table('user_notifications')->truncate();
        Schema::table('user_notifications', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('payload');
            $table->string('notify_type')->after('description');
            $table->string('notify_type_id')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_notifications', function (Blueprint $table) {
            $table->dropColumn('notify_type');
            $table->dropColumn('notify_type_id');
            $table->string('type')->after('description');
            $table->json('payload')->after('description');
        });
    }
}
