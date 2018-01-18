<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{

    public function up()
    {
        Schema::create('tagging_tags', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->index();
            $table->string('slug', 255)->index();
            $table->string('name', 255)->index();
            $table->boolean('suggest')->default(false);
            $table->integer('count')->unsigned()->default(0); // count of how many times this tag was used
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('tagging_tags');
    }
}
