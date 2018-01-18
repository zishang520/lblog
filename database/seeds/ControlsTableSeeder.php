<?php

use Illuminate\Database\Seeder;

class ControlsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('controls')->insert([
            [
                'option_name' => 'blogname',
                'option_value' => '落叶',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'bloginfo',
                'option_value' => '落叶',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'blogurl',
                'option_value' => '',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'detect_url',
                'option_value' => '0',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'index_lognum',
                'option_value' => '10',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'timezone',
                'option_value' => 'Asia/Shanghai',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'login_code',
                'option_value' => '1',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'login_type',
                'option_value' => 'email',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'isexcerpt',
                'option_value' => '1',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'excerpt_subnum',
                'option_value' => '150',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'rss_output_num',
                'option_value' => '100',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'rss_output_fulltext',
                'option_value' => '0',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'iscomment',
                'option_value' => '1',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'comment_interval',
                'option_value' => '60',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'ischkcomment',
                'option_value' => '0',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'comment_code',
                'option_value' => '1',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'isgravatar',
                'option_value' => '0',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'comment_needchinese',
                'option_value' => '0',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'comment_paging',
                'option_value' => '0',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'comment_pnum',
                'option_value' => '20',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'comment_order',
                'option_value' => '0',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'att_maxsize',
                'option_value' => '2048',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'att_type',
                'option_value' => 'rar,zip,gif,jpg,jpeg,png,txt,pdf,docx,doc,xls',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'att_imgmaxw',
                'option_value' => '420',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'att_imgmaxh',
                'option_value' => '460',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'icp',
                'option_value' => '',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'footer_info',
                'option_value' => '',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'widgets',
                'option_value' => '[]',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'permalink',
                'option_value' => '0',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'isalias',
                'option_value' => '0',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'isalias_html',
                'option_value' => '0',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'site_title',
                'option_value' => '',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'site_key',
                'option_value' => '',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'site_description',
                'option_value' => '',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'option_name' => 'log_title_style',
                'option_value' => '1',
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ]);
    }
}
