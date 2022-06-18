<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertEducationDepartment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('education_department')->insert(['punkt_id' => 2, 'bin' => '123456789021', 'iin' => '123456789011', 'full_name' => 'ТЕСТОВ ТЕСТ ТЕСТОВИЧ', 'is_test' => '1']);
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
