<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class GroupsController extends Controller
{
    public function index()
    {
    	$groups = Group::orderBy('name', 'asc')->get();
        $mainTab = 'users';

    	return view('groups.index', compact('groups', 'mainTab'));
    }


    public function create(Request $request)
    {

    	$isEdit = false;

        $users = User::where('access_type', '<>','DATAMAX ADMIN')->orderBy('first_name','asc')->get();
        $userIds = [];

    	if($request->isMethod('post')){

    		$group = Group::FirstorCreate([ 'name' => $request->name, 'details' => $request->details ]);

            $group->users()->sync($request->users);

            log_action(Auth::id(), 'Group Created', 'App\Models\Group', $group->id, $request->name.' Group was created');


            return ['status' => '200', 'data' => $group ];
    	}


    	return view('groups.create', compact('isEdit', 'users', 'userIds'));
    }


    public function view($id='')
    {
    	
    	$group = Group::with('users')->find($id);


    	return view('groups.view', compact('group'));
    }

     public function edit(Request $request, $id)
    {
    	$group = Group::find($id);
    	$isEdit = true;
        $users = User::where('access_type', '<>','DATAMAX ADMIN')->orderBy('first_name','asc')->get();
        $userIds = $group->users()->pluck('id')->toArray();

    	if($request->isMethod('post')){

            $group->update([ 'name' => $request->name, 'details' => $request->details ]);
            $group->users()->sync($request->users);
    
            log_action(Auth::id(), 'Group Edited', 'App\Models\Group', $id, $request->name.' Group was edited');

            return ['status' => '200', 'data' => $group ];
    	}

    	return view('groups.create', compact('group', 'isEdit', 'users', 'userIds'));
    }
}
