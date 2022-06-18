<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateOrganization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE organization ADD nobd_status_id INT(11) NOT NULL DEFAULT '1' COMMENT 'rb_nobd_status.id Статус Нобд' AFTER director_fullname;");
        DB::statement("ALTER TABLE organization ADD access_status_id INT(11) NOT NULL DEFAULT '1' COMMENT 'rb_access_status.id Статус доступа к конкурсу' AFTER nobd_status;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
