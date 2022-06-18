<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRbAccessStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::table('rb_access_status')->insert(['name_kk' => 'Рұқсат етілмеді', 'name_ru' => 'Недопущен', 'color' => '#000000']);
        DB::table('rb_access_status')->insert(['name_kk' => 'Рұқсат', 'name_ru' => 'Допущен', 'color' => '#000000']);
        DB::table('rb_access_status')->insert(['name_kk' => 'Бұғатталған', 'name_ru' => 'Заблокировано', 'color' => '#000000']);
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
