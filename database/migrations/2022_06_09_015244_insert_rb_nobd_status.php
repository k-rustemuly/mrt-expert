<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRbNobdStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('rb_nobd_status')->insert(['name_kk' => 'Тексерілмеді', 'name_ru' => 'Не проверен', 'color' => '#000000']);
        DB::table('rb_nobd_status')->insert(['name_kk' => 'Мәліметтер сәйкес келмейді', 'name_ru' => 'Данные не совпадают', 'color' => '#000000']);
        DB::table('rb_nobd_status')->insert(['name_kk' => 'Мәліметтер табылмады', 'name_ru' => 'Данные не найдены', 'color' => '#000000']);
        DB::table('rb_nobd_status')->insert(['name_kk' => 'Сәйкес келеді', 'name_ru' => 'Данные совпадают', 'color' => '#000000']);
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
