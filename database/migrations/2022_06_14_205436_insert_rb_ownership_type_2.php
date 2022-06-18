<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRbOwnershipType2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('rb_ownership_type')->truncate();
        DB::table('rb_ownership_type')->insert(['name_ru' => 'Государственная собственность', 'name_kk' => 'Мемлекеттік меншік', 'parent_id' => 0, 'is_have_child' => 1, 'code' => '11']);
        DB::table('rb_ownership_type')->insert(['name_ru' => 'Республиканская собственность', 'name_kk' => 'Республикалық меншік', 'parent_id' => 1, 'is_have_child' => 0, 'code' => '12']);
        DB::table('rb_ownership_type')->insert(['name_ru' => 'Коммунальная собственность', 'name_kk' => 'Коммуналдық меншік', 'parent_id' => 1, 'is_have_child' => 0, 'code' => '13']);
        DB::table('rb_ownership_type')->insert(['name_ru' => 'Частная собственность', 'name_kk' => 'Жеке меншік', 'parent_id' => 0, 'is_have_child' => 1, 'code' => '15']);
        DB::table('rb_ownership_type')->insert(['name_ru' => 'Собственность граждан', 'name_kk' => 'Азаматтардың меншігі', 'parent_id' => 4, 'is_have_child' => 0, 'code' => '16']);
        DB::table('rb_ownership_type')->insert(['name_ru' => 'Собственность негосударственных юридических лиц и их объединений', 'name_kk' => 'Мемлекеттік емес заңды тұлғалардың және олардың бірлестігінің меншігі', 'parent_id' => 4, 'is_have_child' => 1, 'code' => '17']);
        DB::table('rb_ownership_type')->insert(['name_ru' => 'Собственность предприятий без государственного и иностранного участия', 'name_kk' => 'Мемлекеттік және шетел қатысусыз кәсіпорындардың меншігі', 'parent_id' => 6, 'is_have_child' => 0, 'code' => '19']);
        DB::table('rb_ownership_type')->insert(['name_ru' => 'Собственность предприятий с участием государства (без иностранного участия)', 'name_kk' => 'Мемлекеттің қатысуымен (шетел қатысусыз) кәсіпорындар меншігі', 'parent_id' => 6, 'is_have_child' => 0, 'code' => '23']);
        DB::table('rb_ownership_type')->insert(['name_ru' => 'Собственность совместных предприятий с иностранным участием', 'name_kk' => 'Шетел қатысумен бірлестік кәсіпорындарының меншігі', 'parent_id' => 6, 'is_have_child' => 0, 'code' => '28']);
        DB::table('rb_ownership_type')->insert(['name_ru' => 'Собственность общественных, в том числе религиозных объединений', 'name_kk' => 'Қоғамдық соның ішінде діни бірлестіктердің меншігі', 'parent_id' => 6, 'is_have_child' => 0, 'code' => '29']);
        DB::table('rb_ownership_type')->insert(['name_ru' => 'Иностранная собственность', 'name_kk' => 'Шетел меншік', 'parent_id' => 0, 'is_have_child' => 1, 'code' => '32']);
        DB::table('rb_ownership_type')->insert(['name_ru' => 'Собственность других государств, их юридических лиц и граждан', 'name_kk' => 'Басқа мемлекеттердің, олардың заңды тұлғаларының және азаматтарының меншігі', 'parent_id' => 11, 'is_have_child' => 1, 'code' => '33']);
        DB::table('rb_ownership_type')->insert(['name_ru' => 'Собственность иностранных государств', 'name_kk' => 'Шетел мемлекеттердің меншігі', 'parent_id' => 12, 'is_have_child' => 0, 'code' => '34']);
        DB::table('rb_ownership_type')->insert(['name_ru' => 'Собственность иностранных юридических лиц', 'name_kk' => 'Шетел заңды тұлғалардың меншігі', 'parent_id' => 12, 'is_have_child' => 0, 'code' => '36']);
        DB::table('rb_ownership_type')->insert(['name_ru' => 'Собственность иностранных физических лиц', 'name_kk' => 'Шетел жеке тұлғалардың меншігі', 'parent_id' => 12, 'is_have_child' => 0, 'code' => '37']);
        DB::table('rb_ownership_type')->insert(['name_ru' => 'Собственность международных организаций', 'name_kk' => 'Халықаралық ұйымдардың меншігі', 'parent_id' => 11, 'is_have_child' => 0, 'code' => '38']);
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
