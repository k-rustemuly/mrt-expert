<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertOrganization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('organization')->insert(['bin' => '123456789021', 'name_kk' => 'Тест', 'name_ru' => 'Тест', 'full_name_kk' => 'Тест толық аты', 'full_name_ru' => 'Полное тестовое имя', 'full_address_kk' => 'Тест адресі', 'full_address_ru' => 'Тестовый адрес', 'is_test' => 1, 'director_fullname' => 'Тестовый Тест Тестович', 'oked_code' => '62021', 'krp_code' => '105', 'kato_code' => '471010000']);
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
