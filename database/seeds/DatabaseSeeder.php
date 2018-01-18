<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(NavbersTableSeeder::class);
        $this->call(ControlsTableSeeder::class);
        $this->call(WidgetsTableSeeder::class);
    }
}
