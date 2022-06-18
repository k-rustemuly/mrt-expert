<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrganization8 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organization', function (Blueprint $table) {
            $table->string('direction', 255)->default("@8@")->comment('rb_org_direction.id через @. Направление ОО')->after('access_status_id');
            $table->integer('education_type_id')->default(3)->comment('rb_education_type.id Типы организации дополнительного образования')->after('direction');
            $table->index('education_type_id');
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
