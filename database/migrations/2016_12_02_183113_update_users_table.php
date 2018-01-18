<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nickname', 255)->nullable()->after('email');
            $table->string('photo', 255)->nullable()->after('nickname');
            $table->text('description')->nullable()->after('photo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nickname');
            $table->dropColumn('photo');
            $table->dropColumn('description');
        });
    }
}
