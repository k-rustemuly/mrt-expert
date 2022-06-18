<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRbEducationType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('rb_education_type')->insert(['name_ru' => 'Дошкольные развивающие комплексы', 'name_kk' => 'Мектепке дейінгі дамыту кешенідері', 'parent_id' => 0, 'is_have_child' => 1, 'code' => '10.001']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Дошкольный развивающий комплекс', 'name_kk' => 'Мектепке дейінгі дамыту кешені', 'parent_id' => 1, 'is_have_child' => 0, 'code' => '10.0011']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Центр', 'name_kk' => 'Орталық', 'parent_id' => 1, 'is_have_child' => 0, 'code' => '10.0012']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Академия', 'name_kk' => 'Академия', 'parent_id' => 1, 'is_have_child' => 0, 'code' => '10.0013']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Дворцы школьников', 'name_kk' => 'Оқушылар сарайлары', 'parent_id' => 0, 'is_have_child' => 1, 'code' => '10.010']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Дворец школьников', 'name_kk' => 'Оқушылар сарайы', 'parent_id' => 5, 'is_have_child' => 0, 'code' => '10.011']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Дом', 'name_kk' => 'Үй', 'parent_id' => 5, 'is_have_child' => 0, 'code' => '10.012']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Центр творчества', 'name_kk' => 'Шығармашылық орталығы', 'parent_id' => 5, 'is_have_child' => 0, 'code' => '10.013']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Комплекс', 'name_kk' => 'Кешен', 'parent_id' => 5, 'is_have_child' => 0, 'code' => '10.014']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Центр детско-юношеского творчества', 'name_kk' => 'Балалар-жасөспірімдер шығармашылық орталығы', 'parent_id' => 5, 'is_have_child' => 0, 'code' => '10.015']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Cтанции юных натуралистов', 'name_kk' => 'Жас натуралистер станциялары', 'parent_id' => 0, 'is_have_child' => 1, 'code' => '10.020']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Станция юных натуралистов', 'name_kk' => 'Жас натуралистер станциясы', 'parent_id' => 11, 'is_have_child' => 0, 'code' => '10.021']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Детский экологический центр', 'name_kk' => 'Балалар экологиялық орталығы', 'parent_id' => 11, 'is_have_child' => 0, 'code' => '10.022']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Биологический центр', 'name_kk' => 'Биологиялық орталық', 'parent_id' => 11, 'is_have_child' => 0, 'code' => '10.023']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Экобиоцентр', 'name_kk' => 'Экобиоорталығы', 'parent_id' => 11, 'is_have_child' => 0, 'code' => '10.024']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Станции юных техников', 'name_kk' => 'Жас техниктер станциялары', 'parent_id' => 0, 'is_have_child' => 1, 'code' => '10.030']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Станция юных техников', 'name_kk' => 'Жас техниктер станциясы', 'parent_id' => 16, 'is_have_child' => 0, 'code' => '10.031']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Центр техников', 'name_kk' => 'Техниктер орталығы', 'parent_id' => 16, 'is_have_child' => 0, 'code' => '10.032']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Школа технического творчества детей и юношества', 'name_kk' => 'Балалар және жасөспірімдер техникалық шығармашылық мектебі', 'parent_id' => 16, 'is_have_child' => 0, 'code' => '10.033']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Станции юных туристов', 'name_kk' => 'Жас туристер станциялары', 'parent_id' => 0, 'is_have_child' => 0, 'code' => '10.040']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Станция юных туристов', 'name_kk' => 'Жас туристер станциясы', 'parent_id' => 20, 'is_have_child' => 0, 'code' => '10.041']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Центр детско-юношеского туризма', 'name_kk' => 'Балалар-жасөспірімдер туризм орталығы', 'parent_id' => 20, 'is_have_child' => 0, 'code' => '10.042']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Детские дворовые клубы', 'name_kk' => 'Балалар аула клубтары', 'parent_id' => 0, 'is_have_child' => 1, 'code' => '10.050']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Детский дворовый клуб', 'name_kk' => 'Балалар аула клубы', 'parent_id' => 23, 'is_have_child' => 0, 'code' => '10.051']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Детский военно-патриотический клуб', 'name_kk' => 'Балалар әскери патриоттық клубы', 'parent_id' => 23, 'is_have_child' => 0, 'code' => '10.052']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Клубная досуговая организация', 'name_kk' => 'Клубтық демалыс ұйымы', 'parent_id' => 23, 'is_have_child' => 0, 'code' => '10.053']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Детские школы искусств', 'name_kk' => 'Балалар өнер мектептері', 'parent_id' => 0, 'is_have_child' => 1, 'code' => '10.060']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Детская школа искусств', 'name_kk' => 'Балалар өнер мектебі', 'parent_id' => 27, 'is_have_child' => 0, 'code' => '10.061']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Детская музыкальная школа', 'name_kk' => 'Балалар музыка мектебі', 'parent_id' => 27, 'is_have_child' => 0, 'code' => '10.062']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Детская художественная школа', 'name_kk' => 'Балалар көркемөнер мектебі', 'parent_id' => 27, 'is_have_child' => 0, 'code' => '10.063']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Школа художественно-эстетической направленности', 'name_kk' => 'Көркем-эстетикалық бағыттағы мектеп', 'parent_id' => 27, 'is_have_child' => 0, 'code' => '10.064']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Детские оздоровительные лагеря', 'name_kk' => 'Балалар сауықтыру орталықтары', 'parent_id' => 0, 'is_have_child' => 1, 'code' => '10.070']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Оздоровительный центр', 'name_kk' => 'Сауықтыру орталығы', 'parent_id' => 32, 'is_have_child' => 0, 'code' => '10.071']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Оздоровительный комплекс', 'name_kk' => 'Сауықтыру кешені', 'parent_id' => 32, 'is_have_child' => 0, 'code' => '10.072']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Загородный оздоровительный лагерь', 'name_kk' => 'Қала сыртындағы сауықтыру лагері', 'parent_id' => 32, 'is_have_child' => 0, 'code' => '10.073']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Лагерь дневного пребывания', 'name_kk' => 'Күндізгі уақытта ұйымдастырылатын лагері', 'parent_id' => 32, 'is_have_child' => 0, 'code' => '10.074']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Палаточный лагерь', 'name_kk' => 'Палаталық лагерь', 'parent_id' => 32, 'is_have_child' => 0, 'code' => '10.075']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Юрточный лагерь', 'name_kk' => 'Киіз үй лагері', 'parent_id' => 32, 'is_have_child' => 0, 'code' => '10.076']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Детско-юношеская спортивная школа', 'name_kk' => 'Балалар-жасөспірімдер спорттық мектебі', 'parent_id' => 0, 'is_have_child' => 0, 'code' => '10.080']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Специализированная детско-юношеская школа олимпийского резерва', 'name_kk' => 'Олимпиадалық резервтегі мамандандырылған балалар-жасөспірімдер мектебі', 'parent_id' => 0, 'is_have_child' => 0, 'code' => '10.090']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Организация по направлениям деятельности и интересам детей', 'name_kk' => 'Балалар қызығушылығы мен жұмыстары бағыты бойынша ұйым', 'parent_id' => 0, 'is_have_child' => 0, 'code' => '10.100']);
        DB::table('rb_education_type')->insert(['name_ru' => 'Учебно-методический и научно-методический  центр дополнительного образования для детей', 'name_kk' => 'Балаларға қосымша білім беру оқу-әдістемелік және ғылыми -әдістемелік орталығы', 'parent_id' => 0, 'is_have_child' => 0, 'code' => '10.110']);
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
