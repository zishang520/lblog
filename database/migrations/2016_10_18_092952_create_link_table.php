<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id'); // id
            $table->string('sitename', 255)->nullable();
            $table->string('siteurl', 255);
            $table->text('description')->nullable(); // 描述
            $table->tinyInteger('hide')->default(0); // 隐藏
            $table->integer('taxis')->default(0); // 排序
            $table->index(['id', 'hide', 'taxis']);
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
        Schema::drop('links');
    }
}
