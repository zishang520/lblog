<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWidgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widgets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->tinyInteger('isdefault')->default(0); // 系统默认
            $table->string('name', 100);
            $table->json('value');
            $table->index(['id', 'name', 'isdefault']);
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
        Schema::drop('widgets');
    }
}
