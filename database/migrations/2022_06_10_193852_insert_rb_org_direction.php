<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRbOrgDirection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('rb_org_direction')->insert(['name_kk' => 'Көркемдік және эстетикалық', 'name_ru' => 'Художественно-эстетическое']);
        DB::table('rb_org_direction')->insert(['name_kk' => 'Ғылыми-техникалық', 'name_ru' => 'Научно-технические']);
        DB::table('rb_org_direction')->insert(['name_kk' => 'Экологиялық және биологиялық', 'name_ru' => 'Эколого-биологическое']);
        DB::table('rb_org_direction')->insert(['name_kk' => 'Туристік және өлкетану', 'name_ru' => 'Туристско-краеведение']);
        DB::table('rb_org_direction')->insert(['name_kk' => 'Әскери-патриоттық', 'name_ru' => 'Военно-патриотическое']);
        DB::table('rb_org_direction')->insert(['name_kk' => 'Әлеуметтік-педагогикалық', 'name_ru' => 'Социально-педагогическое']);
        DB::table('rb_org_direction')->insert(['name_kk' => 'Спорт', 'name_ru' => 'Спортивное']);
        DB::table('rb_org_direction')->insert(['name_kk' => 'Басқа', 'name_ru' => 'Другие']);
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
