<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
    	$count = User::count();
    	if($count == 0)
        User::firstOrCreate([
        			'id'			=> 1,
        			'last_name'   	=> 'Admin',
        			'first_name'   	=> 'Super',
        			'email'   		=> 'admin@datamaxfiles.com',
        			'password'   	=> Hash::make('password'),
                    'access_type'   => 'DATAMAX ADMIN'
        		]);
    }
}
