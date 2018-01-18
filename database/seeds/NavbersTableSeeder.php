<?php

use Illuminate\Database\Seeder;

class NavbersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('navbars')->insert([
            'navname' => '首页',
            'url' => '',
            'newtab' => 0,
            'hide' => 0,
            'taxis' => 0,
            'isdefault' => 1,
            'parent_id' => null,
            'lft' => null,
            'rgt' => null,
            'depth' => null,
            'type' => 1,
            'type_id' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('navbars')->insert([
            'navname' => '登陆',
            'url' => '',
            'newtab' => 0,
            'hide' => 0,
            'taxis' => 0,
            'isdefault' => 1,
            'parent_id' => null,
            'lft' => null,
            'rgt' => null,
            'depth' => null,
            'type' => 2,
            'type_id' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
