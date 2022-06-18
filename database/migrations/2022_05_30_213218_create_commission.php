<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCommission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commission', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->integer('punkt_id')->comment('rb_punkt.id К какому округу относятся');
            $table->integer('commission_type_id')->default(1)->comment('rb_commission_type.id Тип комиссии');
            $table->string('full_name', 255)->nullable()->comment('Полное имя комиссии');
            $table->boolean('is_access')->default(1)->comment('Есть ли доступ к системе?');
            $table->boolean('is_test')->default(0)->comment('Тестовый аккаунт?');
            $table->timestamp('last_visit')->nullable()->comment('Дата и время последного входа в систему');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
        DB::statement("ALTER TABLE commission ADD bin BIGINT(12) UNSIGNED ZEROFILL NOT NULL DEFAULT '0' COMMENT 'БИН организации' AFTER commission_type_id;");
        DB::statement("ALTER TABLE commission ADD iin BIGINT(12) UNSIGNED ZEROFILL NOT NULL DEFAULT '0' COMMENT 'ИИН сотрудника наделенным правом подписи' AFTER bin;");
        DB::statement("ALTER TABLE commission ADD UNIQUE(`bin`, `iin`); ");
        DB::statement("ALTER TABLE commission COMMENT = 'Комиссии отдела образование'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commission');
    }
}
