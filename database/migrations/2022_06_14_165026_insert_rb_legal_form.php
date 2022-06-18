<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRbLegalForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('rb_legal_form')->insert(['name_ru' => 'Государственные предприятия', 'name_kk' => 'Мемлекеттік кәсіпорындар','parent_id' => 0, 'is_have_child' => 1, 'code' => '10']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Государственные предприятия на праве хозяйственного ведения', 'name_kk' => 'Шаруашылық жүргізу құқығында мемлекеттік кәсіпорындар','parent_id' => 1, 'is_have_child' => 0, 'code' => '11']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Государственные предприятия на праве оперативного управления (казенные)', 'name_kk' => 'Жедел басқару (қазыналық) құқығында мемлекеттік кәсіпорын','parent_id' => 1, 'is_have_child' => 0, 'code' => '12']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Хозяйственные товарищества', 'name_kk' => 'Шаруашылық серіктестіктер','parent_id' => 0, 'is_have_child' => 1, 'code' => '15']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Полные товарищества', 'name_kk' => 'Толық серіктестіктер','parent_id' => 4, 'is_have_child' => 0, 'code' => '18']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Коммандитные товарищества', 'name_kk' => 'Коммандиттік серіктестіктер','parent_id' => 4, 'is_have_child' => 0, 'code' => '19']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Товарищества с ограниченной ответственностью', 'name_kk' => 'Жауапкершілігі шектеулі серіктестік','parent_id' => 4, 'is_have_child' => 0, 'code' => '20']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Товарищества с дополнительной ответственностью', 'name_kk' => 'Жауапкершілігі қосымша серіктестік','parent_id' => 4, 'is_have_child' => 0, 'code' => '21']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Акционерные общества', 'name_kk' => 'Акционерлік қоғамдар','parent_id' => 0, 'is_have_child' => 0, 'code' => '28']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Другие организационно-правовые формы', 'name_kk' => 'Басқа ұйымдастыру-құқықтық нысандар','parent_id' => 0, 'is_have_child' => 1, 'code' => '30']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Производственные кооперативы', 'name_kk' => 'Өндірістік кооперативтер','parent_id' => 10, 'is_have_child' => 0, 'code' => '31']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Учреждения', 'name_kk' => 'Мекемелер','parent_id' => 10, 'is_have_child' => 0, 'code' => '35']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Общественные объединения', 'name_kk' => 'Қоғамдық бірлестіктер','parent_id' => 10, 'is_have_child' => 0, 'code' => '36']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Потребительские кооперативы', 'name_kk' => 'Тұтыну кооперативтер','parent_id' => 10, 'is_have_child' => 0, 'code' => '37']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Фонды', 'name_kk' => 'Қорлар','parent_id' => 10, 'is_have_child' => 0, 'code' => '38']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Религиозные объединения', 'name_kk' => 'Діни бірлестіктер','parent_id' => 10, 'is_have_child' => 0, 'code' => '39']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Объединения юридических лиц в форме ассоциации', 'name_kk' => 'Заңды тұлғалардың ассоциация түріндегі бірлестіктер','parent_id' => 10, 'is_have_child' => 0, 'code' => '40']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Сельскохозяйственные товарищества', 'name_kk' => 'Ауыл шаруашылық бірлестік','parent_id' => 10, 'is_have_child' => 0, 'code' => '42']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Индивидуальное предпринимательство', 'name_kk' => 'Жеке кәсіпкерлік','parent_id' => 0, 'is_have_child' => 1, 'code' => '45']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Личное предпринимательство', 'name_kk' => 'Жеке кәсіпкерлік','parent_id' => 19, 'is_have_child' => 0, 'code' => '46']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Индивидуальное предпринимательство на основе совместного предпринимательства', 'name_kk' => 'Бірлескен кәсіпкерлік негізінде жеке кәсіпкерлік','parent_id' => 19, 'is_have_child' => 1, 'code' => '47']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Простое товарищество', 'name_kk' => 'Жай серіктестік','parent_id' => 21, 'is_have_child' => 0, 'code' => '48']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Предпринимательство супругов', 'name_kk' => 'Жұбайлардың кәсіпкерлігі','parent_id' => 21, 'is_have_child' => 0, 'code' => '49']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Семейное предпринимательство', 'name_kk' => 'Отбасылық кәсіпкерлік','parent_id' => 21, 'is_have_child' => 0, 'code' => '50']);
        DB::table('rb_legal_form')->insert(['name_ru' => 'Иные организационно-правовые формы некоммерческой организации', 'name_kk' => 'Коммерциялық емес ұйымның басқа ұйымдастыру-құқықтық нысандар','parent_id' => 0, 'is_have_child' => 0, 'code' => '60']);
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
