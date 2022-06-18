<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateRbOwnershipType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rb_ownership_type', function (Blueprint $table) {
            $table->string('code', 2)->nullable()->comment('Код');
            $table->integer('parent_id')->default(0)->comment('Айди родителя');
            $table->index('parent_id');
            $table->boolean('is_have_child')->default(0)->comment('Есть ли потомки?');
        });
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
