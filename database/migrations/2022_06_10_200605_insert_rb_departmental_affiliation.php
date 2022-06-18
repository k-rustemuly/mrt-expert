<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRbDepartmentalAffiliation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('rb_departmental_affiliation')->insert(['code' => '1', 'name_ru' => 'МОН РК', 'name_kk' => 'ҚР БҒМ']);
        DB::table('rb_departmental_affiliation')->insert(['code' => '2', 'name_ru' => 'Местные исполнительные органы', 'name_kk' => 'Жергілікті атқарушы органдар']);
        DB::table('rb_departmental_affiliation')->insert(['code' => '3', 'name_ru' => 'МЗ РК', 'name_kk' => 'ҚР ДСМ']);
        DB::table('rb_departmental_affiliation')->insert(['code' => '4', 'name_ru' => 'АОО "Назарбаев интелектуальные школы"', 'name_kk' => '"Назарбаев зияткерлік мектептері" ДББҰ']);
        DB::table('rb_departmental_affiliation')->insert(['code' => '5', 'name_ru' => 'Комитет по делам спорта и физической культуры МКС РК', 'name_kk' => 'ҚР МСМ спорт және дене шынықтыру істері комитеті']);
        DB::table('rb_departmental_affiliation')->insert(['code' => '6', 'name_ru' => 'МВД РК', 'name_kk' => 'ҚР ІІМ']);
        DB::table('rb_departmental_affiliation')->insert(['code' => '7', 'name_ru' => 'Министерство обороны РК', 'name_kk' => 'ҚР қорғаныс министрлігі']);
        DB::table('rb_departmental_affiliation')->insert(['code' => '8', 'name_ru' => 'МТСЗН РК', 'name_kk' => 'ҚР ЕХӘҚМ']);
        DB::table('rb_departmental_affiliation')->insert(['code' => '9', 'name_ru' => 'Министерство юстиции', 'name_kk' => 'Әділет министрлігі']);
        DB::table('rb_departmental_affiliation')->insert(['code' => '10', 'name_ru' => 'Верховный Суд Республики Казахстан', 'name_kk' => 'Қазақстан Республикасының Жоғарғы Соты']);
        DB::table('rb_departmental_affiliation')->insert(['code' => '99', 'name_ru' => 'Другие', 'name_kk' => 'ҚБасқалар']);
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
