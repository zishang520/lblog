<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavbarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navbars', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id'); // id
            $table->string('navname', 255);
            $table->string('url', 255)->nullable();
            $table->tinyInteger('newtab')->default(0); // 新窗口
            $table->tinyInteger('hide')->default(0); // 隐藏
            $table->integer('taxis')->default(0); // 排序
            $table->tinyInteger('isdefault')->default(0); // 隐藏
            $table->integer('parent_id')->nullable();
            $table->integer('lft')->nullable();
            $table->integer('rgt')->nullable();
            $table->integer('depth')->nullable();
            $table->tinyInteger('type')->default(0); // 类型
            $table->integer('type_id')->default(0); // 类型id
            $table->index(['id', 'parent_id', 'isdefault']);
            $table->index(['lft', 'rgt', 'depth']);
            $table->index(['type', 'newtab', 'hide', 'taxis']);
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
        Schema::drop('navbars');
    }
}
