<?php

use Illuminate\Database\Seeder;

class WidgetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 个人资料
        DB::table('widgets')->insert([
            [
                'isdefault' => 1,
                'name' => 'BloggerWidget',
                'value' => '{"title":"\u4e2a\u4eba\u8d44\u6599"}',
                'created_at' => date('Y-m-d H:i:s')
            ], [
                'isdefault' => 1,
                'name' => 'CalendarWidget',
                'value' => '{"title":"\u65e5\u5386"}',
                'created_at' => date('Y-m-d H:i:s')
            ], [
                'isdefault' => 1,
                'name' => 'TagWidget',
                'value' => '{"title":"\u6807\u7b7e"}',
                'created_at' => date('Y-m-d H:i:s')
            ], [
                'isdefault' => 1,
                'name' => 'SortWidget',
                'value' => '{"title":"\u5206\u7c7b"}',
                'created_at' => date('Y-m-d H:i:s')
            ], [
                'isdefault' => 1,
                'name' => 'ArchiveWidget',
                'value' => '{"title":"\u5b58\u6863"}',
                'created_at' => date('Y-m-d H:i:s')
            ], [
                'isdefault' => 1,
                'name' => 'NewcommWidget',
                'value' => '{"title":"\u6700\u65b0\u8bc4\u8bba","index_comnum":"10","comment_subnum":"10"}',
                'created_at' => date('Y-m-d H:i:s')
            ], [
                'isdefault' => 1,
                'name' => 'NewlogWidget',
                'value' => '{"title":"\u6700\u65b0\u6587\u7ae0","index_newlog":"10"}',
                'created_at' => date('Y-m-d H:i:s')
            ], [
                'isdefault' => 1,
                'name' => 'HotlogWidget',
                'value' => '{"title":"\u70ed\u95e8\u6587\u7ae0","index_hotlognum":"10"}',
                'created_at' => date('Y-m-d H:i:s')
            ], [
                'isdefault' => 1,
                'name' => 'LinkWidget',
                'value' => '{"title":"\u94fe\u63a5"}',
                'created_at' => date('Y-m-d H:i:s')
            ], [
                'isdefault' => 1,
                'name' => 'SearchWidget',
                'value' => '{"title":"\u641c\u7d22"}',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
