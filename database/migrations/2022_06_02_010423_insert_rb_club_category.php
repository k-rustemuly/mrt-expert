<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRbClubCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('rb_club_category')->insert(['name_ru' => 'Спортивный', 'name_kk' => 'Спорттық']);
        DB::table('rb_club_category')->insert(['name_ru' => 'Художественная эстетика', 'name_kk' => 'Көркем-эстетикалық']);
        DB::table('rb_club_category')->insert(['name_ru' => 'Экологический туризм', 'name_kk' => 'Экологиялық - туризм']);
        DB::table('rb_club_category')->insert(['name_ru' => 'Музыкальный', 'name_kk' => 'Музыкалық']);
        DB::table('rb_club_category')->insert(['name_ru' => 'Технико-творческий', 'name_kk' => 'Техникалық- шығармашылық']);
        DB::table('rb_club_category')->insert(['name_ru' => 'Гуманитарные-естественные науки', 'name_kk' => 'Гуманитарлық-жартылыстану']);
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
