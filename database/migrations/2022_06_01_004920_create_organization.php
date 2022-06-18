<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOrganization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->string('name_kk', 255)->nullable()->comment('Короткое имя компании на казахском');
            $table->string('name_ru', 255)->nullable()->comment('Короткое имя компании на русском');
            $table->string('full_name_kk', 255)->nullable()->comment('Полное имя компании на казахском');
            $table->string('full_name_ru', 255)->nullable()->comment('Полное имя компании на русском');
            $table->string('full_address_kk', 255)->nullable()->comment('Полный адрес компании на казахском');
            $table->string('full_address_ru', 255)->nullable()->comment('Полный адрес компании на русском');
            $table->boolean('is_ip')->default(0)->comment('ИП или нет?');
            $table->boolean('is_test')->default(0)->comment('Тестовая компания?');
            $table->boolean('is_access')->default(1)->comment('Активно ли?');
            $table->string('director_fullname', 128)->nullable()->comment('ФИО директора');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
        DB::statement("ALTER TABLE organization ADD bin BIGINT(12) UNSIGNED ZEROFILL NOT NULL DEFAULT '0' COMMENT 'БИН организации' AFTER id;");
        DB::statement("ALTER TABLE organization ADD UNIQUE(bin);");
        DB::statement("ALTER TABLE organization ADD oked_code INT(5) UNSIGNED ZEROFILL NOT NULL DEFAULT '0' COMMENT 'код ОКЭД' AFTER full_address_ru;");
        DB::statement("ALTER TABLE organization ADD krp_code INT(3) UNSIGNED ZEROFILL NOT NULL DEFAULT '0' COMMENT 'Классификатор размерности предприятия по численности занятых людей (КРП).' AFTER oked_code;");
        DB::statement("ALTER TABLE organization ADD kato_code BIGINT(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '0' COMMENT 'КАТО – классификатор административно-территориального объекта ' AFTER krp_code;");
        DB::statement("ALTER TABLE organization COMMENT = 'Организации'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization');
    }
}
