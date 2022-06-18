<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRbLocalityPart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('rb_locality_part')->insert(['name_ru' => 'Улица', 'name_kk' => 'Көше', 'code' => '01']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Бульвар', 'name_kk' => 'Бульвар', 'code' => '02']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Аллея', 'name_kk' => 'Саяжол', 'code' => '03']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Площадь', 'name_kk' => 'Алаңы', 'code' => '04']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Проспект', 'name_kk' => 'Даңғыл', 'code' => '05']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Линия', 'name_kk' => 'Сызық', 'code' => '06']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Дорога', 'name_kk' => 'Жол', 'code' => '07']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Набережная', 'name_kk' => 'Жағалау', 'code' => '08']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Переулок', 'name_kk' => 'Тар көше', 'code' => '09']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Проезд', 'name_kk' => 'Жол жүру', 'code' => '10']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Зимовка', 'name_kk' => 'Қыстақ', 'code' => '11']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Лесхоз', 'name_kk' => 'Орман шаруашылығы', 'code' => '12']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Воинская часть', 'name_kk' => 'Әскери бөлім', 'code' => '13']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Разъезд', 'name_kk' => 'Разъезд', 'code' => '14']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Станция', 'name_kk' => 'Станция', 'code' => '15']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'База отдыха', 'name_kk' => 'Демалыс базасы', 'code' => '16']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Микрорайон', 'name_kk' => 'Шағын аудан', 'code' => '17']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Квартал', 'name_kk' => 'Квартал', 'code' => '18']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Застава', 'name_kk' => 'Бекет', 'code' => '19']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Шоссе', 'name_kk' => 'Тас жол', 'code' => '20']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Тракт', 'name_kk' => 'Жол', 'code' => '21']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Дачный кооператив', 'name_kk' => 'Саяжайлық кооператив', 'code' => '22']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Гаражный кооператив', 'name_kk' => 'Гараж кооперативі', 'code' => '23']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Массив', 'name_kk' => 'Алап', 'code' => '24']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Гаражное общество', 'name_kk' => 'Гараж қоғамы', 'code' => '25']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Дачное общество', 'name_kk' => 'Саяжайлық қоғам', 'code' => '26']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Трасса', 'name_kk' => 'Трасса', 'code' => '27']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Гаражный массив', 'name_kk' => 'Гараж алабы', 'code' => '28']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Садовое (Садоводческое) общество', 'name_kk' => 'Бақ (бақ шаруашылығы) қоғамы', 'code' => '29']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Жилой массив', 'name_kk' => 'Тұрғын алабы', 'code' => '30']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Участок', 'name_kk' => 'Телім', 'code' => '31']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Промышленная зона', 'name_kk' => 'Өнеркәсіптік аймақ', 'code' => '32']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Отделение', 'name_kk' => 'Бөлімше', 'code' => '33']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Тупик', 'name_kk' => 'Тұйық', 'code' => '34']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Крестьянское хозяйство', 'name_kk' => 'Шаруа қожалығы', 'code' => '35']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Садоводческий коллектив', 'name_kk' => 'Бағбандық ұжым', 'code' => '36']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Потребительский кооператив собственников гаражей', 'name_kk' => 'Гараждардың меншіктенушілерінің тұтынушылар кооперативі', 'code' => '37']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Потребительский кооператив', 'name_kk' => 'Тұтынушылар кооперативі', 'code' => '38']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Садоводческое товарищество', 'name_kk' => 'Бақ шаруашылығы бірлестігі', 'code' => '39']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Дачный массив', 'name_kk' => 'Саяжай алабы', 'code' => '40']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Ферма', 'name_kk' => 'Ферма', 'code' => '41']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Урочище', 'name_kk' => 'Шатқал', 'code' => '42']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Зона', 'name_kk' => 'Аймақ', 'code' => '43']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Потребительский гаражный кооператив', 'name_kk' => 'Гараж тұтынушылар кооперативі', 'code' => '44']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Потребительский кооператив собственников дачных участков', 'name_kk' => 'Саяжай телімдердің меншіктенушілерінің тұтынушылар кооперативі', 'code' => '45']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Таможенный пост', 'name_kk' => 'Кеден бекеті', 'code' => '46']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Лесничество', 'name_kk' => 'Орман шаруашылығы', 'code' => '47']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Кардон', 'name_kk' => 'Кардон', 'code' => '48']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Потребительский кооператив собственников индивидуальных гаражей', 'name_kk' => 'Жеке гараждардың меншіктенушілерінің тұтынушылар кооперативі', 'code' => '49']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Гаражно-строительный кооператив', 'name_kk' => 'Гараж-құрылыстық кооператив', 'code' => '50']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Потребительский кооператив садоводов, садоводческих товариществ', 'name_kk' => 'Бақшашылар, бақ шаруашылығы бірлестіктердің тұтынушылар кооперативі', 'code' => '51']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Заимка', 'name_kk' => 'Зәйімке', 'code' => '52']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Площадка', 'name_kk' => 'Алаң', 'code' => '53']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Территория', 'name_kk' => 'Аумақ', 'code' => '54']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Разрез', 'name_kk' => 'Кескін', 'code' => '55']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Дачный комплекс', 'name_kk' => 'Саяжай кешені', 'code' => '56']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Учетный квартал', 'name_kk' => 'Есеп кварталы', 'code' => '57']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Гаражно-эксплуатационный кооператив', 'name_kk' => 'Гаражды пайдаланылу кооперативі', 'code' => '58']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Кадастровый квартал', 'name_kk' => 'Кадастрлық тоқсан', 'code' => '59']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Садоводческо-потребительский кооператив', 'name_kk' => 'Баушы-тұтынушы кооперативі', 'code' => '60']);
        DB::table('rb_locality_part')->insert(['name_ru' => 'Общество садоводов', 'name_kk' => 'Баушылар қоғамы', 'code' => '61']);
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
