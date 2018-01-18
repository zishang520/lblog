<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('article_id')->unsigned();
            $table->string('nickname', 255);
            $table->string('email', 255)->nullable();
            $table->string('website', 255)->nullable();
            $table->text('content')->nullable();
            $table->string('ip', 100)->nullable();
            $table->tinyInteger('hide')->default(1);
            $table->index(['id', 'article_id', 'ip', 'hide', 'created_at']);
            // $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
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
        Schema::drop('comments');
    }
}
