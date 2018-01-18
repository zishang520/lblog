<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateControlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controls', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');// id
            $table->string('option_name', 100);
            $table->longtext('option_value')->nullable();
            $table->index(['id', 'option_name']);
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
        Schema::drop('controls');
    }
}
