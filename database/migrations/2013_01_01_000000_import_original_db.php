<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ImportOriginalDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run this if the 'users' table doesn't exist yet
        if (!Schema::hasTable('users')) {
            $sql = file_get_contents(base_path('installation/backup/database.sql'));
            DB::unprepared($sql);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No reverse action
    }
}
