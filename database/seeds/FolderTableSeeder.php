<?php

use Illuminate\Database\Seeder;
use App\Models\Folder;

class FolderTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
    	$count = Folder::count();
    	if($count == 0)
        Folder::firstOrCreate([
        			'id'            => 1,
                    'name'     	    => 'root',
        			'description'  	=> 'Root Folder',
        		]);
    }
}
