<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRbTerritorialAffiliation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('rb_territorial_affiliation')->insert(['name_kk' => 'Қалалық аймақ', 'name_ru' => 'Городская местность']);
        DB::table('rb_territorial_affiliation')->insert(['name_kk' => 'Ауылды жер', 'name_ru' => 'Сельская местность']);
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
