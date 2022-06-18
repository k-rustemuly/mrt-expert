<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrganization4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organization', function (Blueprint $table) {
            $table->integer('ownership_type_id')->default(1)->comment('rb_ownership_type.id Форма собственности')->after('access_status_id');
            $table->index('ownership_type_id');
            $table->integer('departmental_affiliation_id')->default(2)->comment('rb_departmental_affiliation.id Ведомственная принадлежность')->after('ownership_type_id');
            $table->index('departmental_affiliation_id');
            $table->integer('territorial_affiliation_id')->default(1)->comment('rb_territorial_affiliation.id Территориальная принадлежность')->after('departmental_affiliation_id');
            $table->index('territorial_affiliation_id');
            $table->integer('legal_form_id')->default(1)->comment('rb_legal_form.id Организационно-правовая форма')->after('territorial_affiliation_id');
            $table->index('legal_form_id');
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
