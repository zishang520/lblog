<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->nullable(); //用户id
            $table->integer('sort_id')->default(0); //分类ID
            $table->string('title', 255); // 标题
            $table->longText('body')->nullable(); //主题内容
            $table->text('excerpt')->nullable();// 描述
            $table->integer('reads')->default(0);// 阅读量
            $table->tinyInteger('hide')->default(0);// 隐藏 草稿箱
            $table->tinyInteger('top')->default(0);// 置顶
            $table->tinyInteger('sorttop')->default(0);// 分类置顶
            $table->tinyInteger('allow_remark')->default(1);// 是否运行评论
            $table->index(['id', 'user_id', 'sort_id']);
            $table->index(['reads', 'hide', 'top', 'sorttop']);
            $table->index(['created_at']);
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
        Schema::drop('articles');
    }
}
