<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRbPunkt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('rb_punkt')->insert(['kato' => 470000000, 'name_kk' => 'Маңғыстау облысы', 'name_ru' => 'Мангистауская область', 'is_have_child' => '1']);
        DB::table('rb_punkt')->insert(['kato' => 471000000, 'parent_id' => 1, 'name_kk' => 'Ақтау Қ.А.', 'name_ru' => 'Актау Г.А.', 'is_have_child' => '1']);
        DB::table('rb_punkt')->insert(['kato' => 471010000, 'parent_id' => 2, 'name_kk' => 'Ақтау қ.', 'name_ru' => 'г. Актау']);
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
