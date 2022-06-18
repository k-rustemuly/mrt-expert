<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRbEducationType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rb_education_type', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->string('code', 10)->nullable()->comment('Код');
            $table->integer('parent_id')->default(0)->comment('Айди родителя');
            $table->index('parent_id');
            $table->boolean('is_have_child')->default(0)->comment('Есть ли потомки?');
            $table->string('name_kk', 255)->nullable()->comment('Наименование на казахском');
            $table->string('name_ru', 255)->nullable()->comment('Наименование на русском');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
        DB::statement("ALTER TABLE rb_education_type COMMENT = 'Типы организации дополнительного образования'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rb_education_type');
    }
}
