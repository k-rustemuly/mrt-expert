<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUpload extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('file_path', 255)->nullable()->comment('Путь до файла');
            $table->string('file_url', 255)->nullable()->comment('Полная ссылка до файла');
            $table->string('file_size', 255)->nullable()->comment('Размер файла в байтах');
            $table->string('file_extension', 50)->nullable()->comment('Расширение');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
        DB::statement("ALTER TABLE upload COMMENT = 'Файлы'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upload');
    }
}
