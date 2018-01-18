<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagGroupsTable extends Migration
{

    public function up()
    {
        Schema::create('tagging_tag_groups', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->index();
            $table->string('slug', 255)->index();
            $table->string('name', 255)->index();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('tagging_tag_groups');
    }
}
