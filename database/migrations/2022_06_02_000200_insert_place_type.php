<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertPlaceType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('rb_place_type')->insert(['name_kk' => 'Стандартты', 'name_ru' => 'Стандартный']);
        DB::table('rb_place_type')->insert(['name_kk' => 'Инклюзивті', 'name_ru' => 'Инклюзивный']);
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
