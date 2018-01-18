<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSortsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sorts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id'); // id
            $table->string('sortname', 255)->nullable(); // 分类名
            $table->string('alias', 255)->nullable();
            $table->text('description')->nullable(); // 描述
            $table->integer('taxis')->default(0); // 排序
            // $table->integer('pid')->default(0); // 上级
            $table->index(['id', 'sortname', 'taxis']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sorts');
    }
}
