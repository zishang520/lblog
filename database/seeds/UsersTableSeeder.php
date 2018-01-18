<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'zishang520@gmail.com',
            'nickname' => '落叶',
            'photo' => '',
            'description' => '自动生成的',
            'password' => '$2y$10$9zBAHo.N3Q2j5YQq71foIOamJFiUVr3tVQDNBDCi/mgGNLquZWXre',
            'remember_token' => 'cXltO09WuV819LhGayowCzLvpJRRZYTT2qfCd19v3vO2uNBq3yWUHi8Amsi3',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
