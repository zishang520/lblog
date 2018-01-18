<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class UpdateSortsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sorts', function (Blueprint $table) {
            $table->integer('parent_id')->nullable()->index()->after('taxis');
            $table->integer('lft')->nullable()->index()->after('parent_id');
            $table->integer('rgt')->nullable()->index()->after('lft');
            $table->integer('depth')->nullable()->index()->after('rgt');
            // $table->dropColumn('pid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropColumn('parent_id');
        $table->dropColumn('lft');
        $table->dropColumn('rgt');
        $table->dropColumn('depth');
        // $table->integer('pid')->default(0)->after('taxis');
    }
}
