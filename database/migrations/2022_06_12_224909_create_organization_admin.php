<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOrganizationAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_admin', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->integer('organization_id')->default(0)->comment('organization.id Айди организации');
            $table->index('organization_id');
            $table->string('full_name', 255)->nullable()->comment('Полное имя сотрудника');
            $table->boolean('is_access')->default(1)->comment('Есть ли доступ к системе?');
            $table->boolean('is_test')->default(0)->comment('Тестовый аккаунт?');
            $table->timestamp('last_visit')->nullable()->comment('Дата и время последного входа в систему');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
        DB::statement("ALTER TABLE organization_admin ADD iin BIGINT(12) UNSIGNED ZEROFILL NOT NULL DEFAULT '0' COMMENT 'ИИН сотрудника' AFTER organization_id;");
        DB::statement("ALTER TABLE organization_admin COMMENT = 'Админстраторы организации образование'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_admin');
    }
}
