<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRbEducationOrganizationFileType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('rb_education_organization_file_type')->insert(['name_kk' => 'Санитариялық-эпидемиологиялық қорытындының көшірмесі', 'name_ru' => 'Копия санитарно-эпидемиологического заключения']);
        DB::table('rb_education_organization_file_type')->insert(['name_kk' => 'Анықтама немесе мемлекеттік тіркеу туралы куәліктің көшірмесі', 'name_ru' => 'Справка или копию свидетельства о государственной регистрации']);
        DB::table('rb_education_organization_file_type')->insert(['name_kk' => 'Салық берешегінің және міндетті зейнетақы жарналары бойынша берешегінің жоқтығы туралы мәліметтер', 'name_ru' => 'Сведения об отсутствии налоговой задолженности и задолженности по обязательным пенсионным взносам']);
        DB::table('rb_education_organization_file_type')->insert(['name_kk' => 'Жылжымайтын мүлікке құқық белгілейтін құжаттардың көшірмесі немесе жалдау шартының көшірмесі', 'name_ru' => 'Копия правоустанавливающих документов на недвижимое имущество либо копия договора аренды']);
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
