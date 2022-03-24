<?php

use Illuminate\Database\Seeder;
use App\Models\ValueList;

class ValueListTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
    	ValueList::firstOrCreate([
        			'id'            => 1,
                    'name'     	    => 'Users',
        			'description'  	=> 'All active users on the system.',
                    'type'          => 'PRE-DEFINED',
                    'model'         => 'App\Models\User'
        		]);

        ValueList::firstOrCreate([
                    'id'            => 2,
                    'name'          => 'Groups',
                    'description'   => 'All active groups on the system.',
                    'type'          => 'PRE-DEFINED',
                    'model'         => 'App\Models\Group'
                ]);

        ValueList::firstOrCreate([
                    'id'            => 3,
                    'name'          => 'Categories',
                    'description'   => 'All active categories on the system.',
                    'type'          => 'PRE-DEFINED',
                    'model'         => 'App\Models\Folder'
                ]);

        ValueList::firstOrCreate([
                    'id'            => 4,
                    'name'          => 'Documents',
                    'description'   => 'All active documents on the system.',
                    'type'          => 'PRE-DEFINED',
                    'model'         => 'App\Models\File'
                ]);

        ValueList::firstOrCreate([
                    'id'            => 5,
                    'name'          => 'Workflow',
                    'description'   => 'All active workflows on the system.',
                    'type'          => 'PRE-DEFINED',
                    'model'         => 'App\Models\Workflow'
                ]);

        ValueList::firstOrCreate([
                    'id'            => 6,
                    'name'          => 'Workflow state',
                    'description'   => 'All active workflow state on the system.',
                    'type'          => 'PRE-DEFINED',
                    'model'         => 'App\Models\WorkflowStep'
                ]);
    }
}
