<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(FolderTableSeeder::class);
        $this->call(CompanyTableSeeder::class);
        $this->call(ValueListTableSeeder::class);
    }
}
