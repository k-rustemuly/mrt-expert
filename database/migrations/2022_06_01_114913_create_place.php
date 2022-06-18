<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePlace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->integer('punkt_id')->comment('rb_punkt.id К какому округу относятся?');
            $table->index('punkt_id');
            $table->integer('club_category_id')->default(1)->comment('rb_club_category.id К какой категории относятся?');
            $table->index('club_category_id');
            $table->integer('club_subcategory_id')->default(1)->comment('rb_club_subcategory.id К какой субкатегории относятся?');
            $table->index('club_subcategory_id');
            $table->integer('quantity')->default(0)->comment('Количество выделенных мест');
            $table->decimal('amount', 8, 2)->default(0)->comment('Сумма на одного ребенка');
            $table->integer('place_type_id')->default(1)->comment('rb_place_type.id Тип места');
            $table->index('place_type_id');
            $table->integer('place_status_id')->default(1)->comment('rb_place_status.id Статус');
            $table->index('place_status_id');
            $table->integer('author_id')->comment('education_department.id Кто создал?');
            $table->index('author_id');
            $table->boolean('is_test')->default(0)->comment('Тестовый запись?');
            $table->timestamp('start_date')->nullable()->comment('Начало приема заявок');
            $table->timestamp('end_date')->nullable()->comment('Конец приема заявок');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
        DB::statement("ALTER TABLE place COMMENT = 'Места'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('place');
    }
}
