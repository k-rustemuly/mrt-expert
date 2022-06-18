<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRbAccessStatus3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('rb_access_status')->insert(['name_kk' => 'Бұғатталған', 'name_ru' => 'Запрещено', 'color' => '#000000']);
        DB::table('rb_access_status')->insert(['name_kk' => 'Құқығы жоқ', 'name_ru' => 'Не имеет право', 'color' => '#000000']);
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
