<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrganization5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organization', function (Blueprint $table) {
            $table->date('opening_date')->nullable()->comment('Дата открытия')->after('legal_form_id');
            $table->string('site', 255)->nullable()->comment('Сайт')->after('legal_form_id');
            $table->string('email', 255)->nullable()->comment('Email')->after('legal_form_id');
            $table->string('cellular_telephone', 50)->nullable()->comment('Сотовый  телефон')->after('legal_form_id');
            $table->string('work_phone', 50)->nullable()->comment('Рабочий телефон')->after('legal_form_id');
            $table->string('fax', 50)->nullable()->comment('Факс (код+номер)')->after('legal_form_id');
            $table->string('map_coordinates', 50)->nullable()->comment('Координаты на карте (широта, долгота)')->after('legal_form_id');
            $table->string('house_number', 50)->nullable()->comment('Номер дома')->after('legal_form_id');
            $table->string('locality_name', 255)->nullable()->comment('Наименование составной части населенного пункта')->after('legal_form_id');
            $table->integer('locality_part_id')->default(1)->comment('rb_locality_part.id Тип составной части населенного пункта')->after('legal_form_id');
            $table->index('locality_part_id');
            $table->string('postcode', 50)->nullable()->comment('Почтовый индекс')->after('legal_form_id');
            $table->boolean('is_ppp')->default(0)->comment('Функционирует в рамках ГЧП?')->after('legal_form_id');
        });
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
