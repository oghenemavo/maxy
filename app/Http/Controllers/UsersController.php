<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Group;
use App\Models\User;
use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Hash;
use Auth;
use Carbon\Carbon;
use Session;
use URL;
use Redirect;
use Excel;

class UsersController extends Controller
{
    

    public function logout(){

        log_action(Auth::id(), 'User Logout', 'App\Models\User', Auth::id(), 'User logout.');

        
        Auth::logout();
        return redirect()->route('login');
    }

    public function index()
    {
    	$users = User::where('access_type', '<>', 'DATAMAX ADMIN')->orderBy('first_name', 'asc')->get();
        $mainTab = 'users';

    	return view('users.index', compact('users', 'mainTab'));
    }

    public function activateUser(Request $request, $userId, $status)
    {
        if($status == 1) {
            $user_count = User::where('access_type', '<>', 'DATAMAX ADMIN')->count();
            $inactive_users = User::where('is_active', '0')->count();
            $settings = settings();
    
            if(($user_count-$inactive_users) >= $settings['user_limit']) {
                $msg = 'You can not active this user as you have  '.$settings['user_limit']. ' number of licenses' ;
                return back()->with('error', $msg);
            }
        }
        
        User::find($userId)->update(['is_active' => $status]);
            
            $msg = 'User has been successfully de-activated';

        if($status)
            $msg = 'User has been successfully activated';

        return back()->with('success', $msg);
    }

    public function importUser(Request $request)
    {
        if($request->isMethod('post')){
            // dd($request);
                $this->validate($request,['file'=> 'required|mimes:xls,xlsx']);
                    $filepath = $request->file('file')->getRealPath();
                    $data = Excel::load($filepath)->get();
                    // dd($data);
                    if(count($data) == 0){
                        
                     return  redirect()->back()->with('error','Your spreadsheet is empty');
                    }                   
                else{
                    foreach($data as $values){
                            dump($values);
                            $data = [ 
                                'first_name' => $values->first_name, 
                                'last_name' => $values->last_name, 
                                'email' => $values->email, 
                                'is_active' => 0, 
                                'access_type' => 'General Staff', 
                                // 'username' => $values->username, 
                                'username' => $values->staff_id, 
                                'password' => Hash::make('password') 
                            ];
                            $user = User::FirstorCreate($data);
                            // dump($user);
                        }
                        log_action(Auth::id(), 'User List Imported', 'App\Models\User', Auth::id(), 'User List was imported');
                    return redirect()->back()->with('success','User List was imported successfully');
                }
            }
        return view('users.import');
    }


    public function create(Request $request)
    {

    	$isEdit = false;
        $groups = Group::orderBy('name','asc')->get();
        $groupIds = [];

    	if($request->isMethod('post')){

            $user_count = User::where('access_type', '<>', 'DATAMAX ADMIN')->count();
            $inactive_users = User::where('is_active', '0')->count();
            $settings = settings();

            if(($user_count-$inactive_users) >= $settings['user_limit'])
            
                return ['status' => '500', 'data' => 'You can not add more user. You have passed your current user limit of '.$settings['user_limit'] ];

            $data = [ 
                        'first_name' => $request->first_name, 
                        'last_name' => $request->last_name, 
                        'email' => $request->email, 
                        'username' => $request->username, 
                        'staff_id' => $request->staff_id, 
                        'password' => Hash::make($request->password) 
                    ];

            if(in_array(Auth::user()->access_type, [ "DATAMAX ADMIN", "COMPANY ADMIN" ]))       
                $data['access_type'] = $request->access_type;

    		$user = User::FirstorCreate($data);
            $user->groups()->sync($request->groups);

            log_action(Auth::id(), 'User Created', 'App\Models\User', $user->id, $request->first_name.' was created');

            return ['status' => '200', 'data' => $user ];
    	}


    	return view('users.create', compact('isEdit', 'groups', 'groupIds'));
    }


    public function view($id='')
    {
    	
    	$user = User::find($id);

    	return view('users.view', compact('user'));
    }

     public function edit(Request $request, $id='')
    {
    	$user = User::find($id);
    	$isEdit = true;
        $groups = Group::get();
        $groupIds = $user->groups()->pluck('id')->toArray();

    	if($request->isMethod('post')){

            $data = [ 
                        'first_name' => $request->first_name, 
                        'last_name' => $request->last_name, 
                        'email' => $request->email, 
                        'username' => $request->username, 
                        'staff_id' => $request->staff_id 
                    ];
            if(in_array(Auth::user()->access_type, [ "DATAMAX ADMIN", "COMPANY ADMIN" ]))        
                $data['access_type'] = $request->access_type;

    		User::find($id)->update($data);


            // Sync Group
            $user->groups()->sync($request->groups);

            log_action(Auth::id(), 'User Edited', 'App\Models\User', $id, $request->first_name.' details was updated');


            return ['status' => '200', 'data' => $user ];
    	}

    	return view('users.create', compact('user', 'groups', 'isEdit', 'groupIds'));
    }


    public function resetPassword($userId)
    {
        $user = User::find($userId)->update([ 'password' => Hash::make(env('DEAFULT_PASSWORD', 'password')), 'must_change_password' => 1 ]);

        $user = User::find($userId);        
        log_action(Auth::id(), 'Reset Password', 'App\Models\User', $user->id, 'Admin reset the password of  '.$user->first_name.' to default');

        return redirect()->back()->with('success', 'Password of user has been changed back to the default password: "'.env('DEAFULT_PASSWORD', 'password') .'"');
    }

    public function dashboard(Request $request)
    {
        // dd($request->fullUrl());
	$agent = new Agent();
        if(!Auth::check()){
            $request->session()->put('redirect_url', $request->fullUrl());
            return redirect()->route('welcome');
        }


        if ($request->session()->has('redirect_url')) {
            $red_url = $request->session()->get('redirect_url');
            // dd($red_url);
            $request->session()->forget('redirect_url');

            return Redirect::to($red_url);
        }

        $user = Auth::user();
        $mainTab = 'dashboard';
        
        //logs
        $todayStart = Carbon::now()->startOfDay();
        $todayEnd = Carbon::now()->endOfDay();
        $pastWeek = $todayEnd->copy()->subWeek();
        $pastMonth = $todayEnd->copy()->subMonth();

        $todayLog = $user->logs()->whereBetween('created_at', [$todayStart, $todayEnd])->orderBy('created_at', 'desc')->get();
        $weekLog = $user->logs()->whereBetween('created_at', [$pastWeek, $todayEnd])->orderBy('created_at', 'desc')->get();
        $monthLog = $user->logs()->whereBetween('created_at', [$pastMonth, $todayEnd])->orderBy('created_at', 'desc')->get();
        


        //recent files...
        $files = File::with('createdByUser', 'auth_user')->where("uncategorized", 0)->orderBy('created_at', 'desc')->take(7)->get();
        $last_mod_files = File::with('createdByUser', 'auth_user')->where("uncategorized", 0)->orderBy('last_modified', 'desc')->take(5)->get();

        //Files assigned to a user
        $assFiles = File::where('workflow_step_id', '<>', null)->orderBy('created_at', 'desc')->get();

        foreach ($assFiles as $assignedFile) {
            if(!$assignedFile->is_locked){
                $assignedFiles[] = $assignedFile;
            }
        }
       
       
        
        

        // dd($files->toArray());
        $file_id = $request->file_id;
        $message = $request->message;


        return view('users.dashboard', compact('user', 'mainTab', 'agent' ,'last_mod_files', 'files', 'weekLog', 'todayLog', 'monthLog', 'file_id', 'message', 'assignedFiles'));
    }


    public function changePassword(Request $request)
    {
        
        if($request->isMethod('post')){

            $user = Auth::user();

            if(Hash::check($request->curr_pass, $user->password) ){

                $user->password = Hash::make($request->new_pass);
                $user->save();

                log_action(Auth::id(), 'Password change', 'App\Models\User', Auth::user()->id, $user->first_name.' changed their password.');


                return ['status' => '200'];
            }else{

                return ['status' => '500'];
            }


            
        }


        return view('users.change-password');
    }

    public function ajaxStats(Request $request)
    {
        $count = [];

        // dd($request->all());

        switch ($request->period) {
            case 'thisWeek':
                $start = Carbon::now()->startOfWeek();
                $end = $start->copy()->endOfWeek();
                break;
            
            case 'lastWeek':
                $start = Carbon::now()->subWeek()->startOfWeek();
                $end = $start->copy()->endOfWeek();
                break;
            
            case 'lastMonth':
                $start = Carbon::now()->subMonth()->startOfMonth();
                $end = $start->copy()->endOfMonth();
                break;
            
            case 'thisMonth':
                $start = Carbon::now()->startOfMonth();
                $end = $start->copy()->endOfMonth();
                break;
            
            default:
                $start = Carbon::now()->startOfMonth();
                $end = $start->copy()->endOfMonth();
                break;
        }

        // dump($start);
        // dump($end);

        $count['fileCount']     = File::where('uncategorized',  FALSE)->count();
        $count['folderCount']   = Folder::count() - 1;
        $count['userCount']     = User::count();

        $count['fileCountP']     = File::whereBetween('created_at', [$start, $end])->where('uncategorized',  FALSE)->count();
        $count['folderCountP']   = Folder::whereBetween('created_at', [$start, $end])->count() - 1 ;
        $count['userCountP']     = User::whereBetween('created_at', [$start, $end])->count();



        
        return view('users.stats-ajax', compact('count'));
    }

    public function checkSession(Request $request)
    {
        $resp = [];

        
        if( Auth::check() && Auth::user()->session_id ==  Session::getId())
            $resp['status'] = true;
        else
            $resp['status'] = false;


        echo $resp['status'];
        exit;
    }

    public function clearNotification()
    {
       $notification =  Auth::user()->notifications();
        // dd($notification);
        $notification->delete();
        $msg = 'All notifications has been cleared....';

        return redirect()->back()->with('success', $msg);

    }

}
