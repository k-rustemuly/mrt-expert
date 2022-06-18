<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRbAccessStatus2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('rb_access_status')->truncate();
        DB::table('rb_access_status')->insert(['name_kk' => 'Толтырылуда', 'name_ru' => 'Заполняется', 'color' => '#000000']);
        DB::table('rb_access_status')->insert(['name_kk' => 'Тексерілуде', 'name_ru' => 'На проверке', 'color' => '#000000']);
        DB::table('rb_access_status')->insert(['name_kk' => 'Рұқсат етілді', 'name_ru' => 'Допущен', 'color' => '#000000']);
        DB::table('rb_access_status')->insert(['name_kk' => 'Рұқсат жоқ', 'name_ru' => 'Не допущен', 'color' => '#000000']);
        DB::table('rb_access_status')->insert(['name_kk' => 'Мәліметтер ескірген', 'name_ru' => 'Данные устарели', 'color' => '#000000']);
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
