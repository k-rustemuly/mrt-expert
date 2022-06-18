<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRbClubSubcategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('rb_club_subcategory')->insert(['parent_id' => 1, 'name_kk' => 'Тоғызқұмалақ', 'name_ru' => 'Тогызкумалак']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 1, 'name_kk' => 'Шахмат', 'name_ru' => 'Шахмат']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 1, 'name_kk' => 'Дойбы', 'name_ru' => 'Шашки']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 1, 'name_kk' => 'Каратэ', 'name_ru' => 'Каратэ']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 1, 'name_kk' => 'Жеңіл атлетика', 'name_ru' => 'Легкая атлетика']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 1, 'name_kk' => 'Кроссфит - Жүгіру', 'name_ru' => 'Кроссфит - Бег']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 1, 'name_kk' => 'Қолкүрес', 'name_ru' => 'Рукоборье']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 1, 'name_kk' => 'Гимнастика', 'name_ru' => 'Гимнастика']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 1, 'name_kk' => 'Таеквондо', 'name_ru' => 'Таеквондо']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 1, 'name_kk' => 'Сапқа тұру', 'name_ru' => 'Построение']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 1, 'name_kk' => 'Ұлттық ойындар', 'name_ru' => 'Национальные игры']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 1, 'name_kk' => 'Волейбол', 'name_ru' => 'Волейбол']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 1, 'name_kk' => 'Баскетбол', 'name_ru' => 'Баскетбол']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 1, 'name_kk' => 'Футбол', 'name_ru' => 'Футбол']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 1, 'name_kk' => 'Жас құтқарушы', 'name_ru' => 'Молодой спаситель']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 1, 'name_kk' => 'Теннис', 'name_ru' => 'Теннис']);

        DB::table('rb_club_subcategory')->insert(['parent_id' => 2, 'name_kk' => 'Сахна шеберлігі', 'name_ru' => 'Сценические навыки']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 2, 'name_kk' => 'Қолөнер', 'name_ru' => 'Рукоделие']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 2, 'name_kk' => 'Тігін', 'name_ru' => 'Шитьё']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 2, 'name_kk' => 'Сурет - бейнелеу', 'name_ru' => 'Иллюстрация']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 2, 'name_kk' => 'Театр - драма', 'name_ru' => 'Театр - драма']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 2, 'name_kk' => 'Риторика', 'name_ru' => 'Риторика']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 2, 'name_kk' => 'Заманауи дизайн', 'name_ru' => 'Современный дизайн']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 2, 'name_kk' => 'Хореография', 'name_ru' => 'Хореография']);
        
        DB::table('rb_club_subcategory')->insert(['parent_id' => 3, 'name_kk' => 'Жас гүл өсіруші', 'name_ru' => 'Молодой флорист']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 3, 'name_kk' => 'Жас ботаник', 'name_ru' => 'Молодой ботаник']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 3, 'name_kk' => 'Өсімдіктер мен дизайн', 'name_ru' => 'Растения и дизайн']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 3, 'name_kk' => 'Экология', 'name_ru' => 'Экология']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 3, 'name_kk' => 'Биология', 'name_ru' => 'Биология']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 3, 'name_kk' => 'Өлкетану', 'name_ru' => 'Краеведение']);

        DB::table('rb_club_subcategory')->insert(['parent_id' => 4, 'name_kk' => 'Ансамбль', 'name_ru' => 'Ансамбль']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 4, 'name_kk' => 'Вокал', 'name_ru' => 'Вокал']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 4, 'name_kk' => 'Ән салу', 'name_ru' => 'Пение']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 4, 'name_kk' => 'Домбыра', 'name_ru' => 'Домбра']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 4, 'name_kk' => 'Гитара', 'name_ru' => 'Гитара']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 4, 'name_kk' => 'Жыр - терме', 'name_ru' => 'Жыр терме']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 4, 'name_kk' => 'Жетіген', 'name_ru' => 'Жетыген']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 4, 'name_kk' => 'Баян', 'name_ru' => 'Баян']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 4, 'name_kk' => 'Қобыз', 'name_ru' => 'Кобыз']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 4, 'name_kk' => 'Скрипка', 'name_ru' => 'Скрипка']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 4, 'name_kk' => 'Виоленчель', 'name_ru' => 'Виоленчель']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 4, 'name_kk' => 'Шертер', 'name_ru' => 'Шертер']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 4, 'name_kk' => 'Прима', 'name_ru' => 'Прима']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 4, 'name_kk' => 'Фортепиано', 'name_ru' => 'Фортепиано']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 4, 'name_kk' => 'Флита', 'name_ru' => 'Флита']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 4, 'name_kk' => 'Саксафон', 'name_ru' => 'Саксафон']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 4, 'name_kk' => 'Кларнет', 'name_ru' => 'Кларнет']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 4, 'name_kk' => 'Сазсырнай', 'name_ru' => 'Сазсырнай']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 4, 'name_kk' => 'Дәстүрлі ән', 'name_ru' => 'Традиционная песня']);

        DB::table('rb_club_subcategory')->insert(['parent_id' => 5, 'name_kk' => 'Робототехника', 'name_ru' => 'Робототехника']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 5, 'name_kk' => 'Әуемодельдеу', 'name_ru' => 'Авиамоделирование']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 5, 'name_kk' => 'Жас техник', 'name_ru' => 'Молодой техник']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 5, 'name_kk' => 'IT class', 'name_ru' => 'IT class']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 5, 'name_kk' => 'Планетария', 'name_ru' => 'Планетария']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 5, 'name_kk' => 'СТЕМ', 'name_ru' => 'СТЕМ']);

        DB::table('rb_club_subcategory')->insert(['parent_id' => 6, 'name_kk' => 'ЗЕРДЕ', 'name_ru' => 'ЗЕРДЕ']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 6, 'name_kk' => 'Enqlish club', 'name_ru' => 'Enqlish club']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 6, 'name_kk' => 'Әдебиет әлемі', 'name_ru' => 'Мир литературы']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 6, 'name_kk' => 'Қазақша үйренейік', 'name_ru' => 'Учимся по-казахски']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 6, 'name_kk' => 'Сөз өнері', 'name_ru' => 'Искусство слова']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 6, 'name_kk' => 'Ағылшын тілі', 'name_ru' => 'Английский язык']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 6, 'name_kk' => 'Қызықты психология', 'name_ru' => 'Интересная психология']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 6, 'name_kk' => 'Зияткерлік ойындар', 'name_ru' => 'Интеллектуальные игры']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 6, 'name_kk' => 'Қызықты математика', 'name_ru' => 'Интересная математика']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 6, 'name_kk' => 'Ментальды арифметика', 'name_ru' => 'Ментальная арифметика']);
        DB::table('rb_club_subcategory')->insert(['parent_id' => 6, 'name_kk' => 'Абайтану', 'name_ru' => 'Абаеведение']);
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
