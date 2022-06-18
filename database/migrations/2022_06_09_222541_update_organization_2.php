<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrganization2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE organization ADD punkt_id INT(11) NOT NULL DEFAULT '1' COMMENT 'rb_punkt.id К какому округу относятся' AFTER director_fullname;");
        Schema::table('organization', function (Blueprint $table) {
            $table->index('punkt_id');
        });
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
