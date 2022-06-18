<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRbPlaceStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('rb_place_status')->insert(['name_kk' => 'Жоба', 'name_ru' => 'Черновик', 'color' => '#000000']);
        DB::table('rb_place_status')->insert(['name_kk' => 'Жарияланды', 'name_ru' => 'Опубликовано', 'color' => '#000000']);
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
