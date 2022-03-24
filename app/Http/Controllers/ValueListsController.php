<?php

namespace App\Http\Controllers;

use App\Models\ValueList;
use App\Models\ValueListItem;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Auth;
use Excel;

class ValueListsController extends Controller
{
    public function index()
    {
    	$vlists = ValueList::orderBy('type', 'asc')->get();
        $mainTab = 'file-controls';

    	return view('vlists.index', compact('vlists', 'mainTab'));
    }


    public function create(Request $request)
    {
        $isEdit = false;
        
    	if($request->isMethod('post')){

            if($request->type == 0){
                $vlist = ValueList::FirstorCreate([ 'name' => $request->name, 'description' => $request->description, 'type' => 'LOCAL' ]);
    
    
                $items = explode(",", $request->items);
                foreach ($items as $item) {
                        if(trim($item) != ""){
                            $i = new \App\Models\ValueListItem(['name' => $item]);
                            $vlist->items()->save($i);
                        }
                        
                    }
                } 
            elseif($request->type == 1) {
                    $hostname = $request->hostname;
                    $database = $request->database;
                    $username = $request->username;
                    $password = $request->password;
                    $dbname = $request->dbname;
                    $statement = $request->statement;


                    $vlist = ValueList::FirstorCreate(['name' => $request->name, 'description' => $request->description,
                                'type'=>'REMOTE'],['connection_details' => json_encode(compact("hostname", 
                                                    "database","username","password","dbname","statement"))]);
                    $this->pullDB($vlist->id);
                    return redirect()->back()->with('success','Value List created successfully');
                }
            else {
                $this->validate($request,['file'=> 'required|mimes:xls,xlsx']);
                    $filepath = $request->file('file')->getRealPath();
                    $data = Excel::load($filepath)->get();
                    if(count($data) == 0){
                        
                     return  redirect()->back()->with('error','Your spreadsheet is empty');
                    }                   
                else{
                    $vlist = ValueList::FirstorCreate(['name'=>$request->name,'description'=>$request->description,
                'type'=>'EXCEL']);
                    foreach($data as $values){
                        foreach($values as $list){
                            // dump($list);
                            DB::table('value_list_items')->insert(
                                ['value_list_id' => $vlist->id, 'name' => $list]
                            );
                        }
                    }
                    return redirect()->back()->with('success','Value List created successfully');
                }
   
            }

            log_action(Auth::id(), 'ValueList Created', 'App\Models\ValueList', $vlist->id, $request->name.' ValueList was created');
            return redirect()->back();
    	}

    	return view('vlists.create', compact('isEdit'));

    }


    public function view($id='')
    {

        $group = ValueList::with('users')->find($id);


    	return view('vlists.view', compact('group'));
    }

     public function edit(Request $request, $id)
    {
        $isEdit = true;
        $vlist = ValueList::find($id);
        // dd($vlist);
        $item_str = implode(",", $vlist->items()->pluck('name')->toArray() );
        
    	if($request->isMethod('post')){
            if($vlist->type == 'LOCAL'){
                $vlist->update([ 'name' => $request->name, 'description' => $request->description , 'type' => 'LOCAL' ]);
                $vlist->items()->delete();
                $items = explode(",", $request->items);
                foreach ($items as $item) {
                    if(trim($item) != ""){
                        $i = new \App\Models\ValueListItem(['name' => $item]);
                        $vlist->items()->save($i);
                    }               
                }
            }
            else {
                $hostname = $request->hostname;
                $database = $request->database;
                $username = $request->username;
                $password = $request->password;
                $dbname = $request->dbname;
                $statement = $request->statement;
                $connection = json_encode(compact("hostname", "database","username","password","dbname","statement"));
                //  dd($connection);
                $vlist->update(['name' => $request->name, 'description' => $request->description,
                'type'=>'REMOTE','connection_details' =>$connection ]);
                $vlist->items()->delete();
                $this->pullDB($vlist->id);     
            }
            log_action(Auth::id(), 'Value List Edited', 'App\Models\ValueList', $id, $request->name.' Value List was edited');
            return redirect()->back();
        }
        
        
    	return view('vlists.create', compact('item_str', 'isEdit', 'vlist'));
    }
    
    public function delList(Request $request, $listId){
        
        $vlist = ValueList::find($listId);
        $vlist->delete();
        
        log_action(Auth::id(), 'Value List Deleted', 'App\Models\ValueList', $listId, $vlist->name.' Value List was Deleted');
        return redirect()->back()->with('success', 'Value list was deleted successfully.');
        
    }
    
    public function refresh($id)
    {
        $vlist = ValueList::find($id);
        $this->refreshDB($vlist->id);
        // return ['status' => '200', 'data' => $vlist ];
        log_action(Auth::id(), 'Value List Refreshed', 'App\Models\ValueList', $id, $vlist->name.' Value List was Refreshed');
        return redirect()->back();
    }


    private function pullDB($id){
        $connectionDetails = ValueList::where('id', $id)->pluck('connection_details')->first();
        $details = json_decode($connectionDetails, true);
        $hostname = $details['hostname'];
        $username = $details['username'];
        $password = $details['password'];
        $dbname = $details['dbname'];
        $statement = $details['statement'];
        // $vlist = ValueList::find($id);
        $vlist = ValueList::where('id', $id)->pluck('id')->first();
        
        $connectionInfo = array( "Database"=>$dbname, "UID"=>$username, "PWD"=>$password);
        $conn = sqlsrv_connect( $hostname, $connectionInfo);
        if(!$conn){
            return redirect()->back()->with('error', 'Please check your connection details and enter the correct values');
        }
        
        $result = sqlsrv_query($conn, $statement );
        if(!$result){
            return redirect()->back()->with('error', 'Please enter a valid SQL Query');
        }
        else {
            while( $item = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
                $string = implode( ", ", $item );
                DB::table('value_list_items')->insert(
                    ['value_list_id' => $vlist, 'name' => $string]
                );
                return redirect()->back()->with('success','Value List created and pulled from database successfully'); 
            }
        }
    }

    private function refreshDB($id){
        $connectionDetails = ValueList::where('id', $id)->pluck('connection_details')->first();
        $details = json_decode($connectionDetails, true);
        $hostname = $details['hostname'];
        $username = $details['username'];
        $password = $details['password'];
        $dbname = $details['dbname'];
        $statement = $details['statement'];
        $vlist = ValueList::where('id', $id)->pluck('id')->first();
        $vlistItems = ValueListItem::where('value_list_id', $id)->pluck('name');
        foreach($vlistItems as $vlistItem){
            $value[] = $vlistItem;
        }
        
        $connectionInfo = array( "Database"=>$dbname, "UID"=>$username, "PWD"=>$password);
        $conn = sqlsrv_connect( $hostname, $connectionInfo);
        if(!$conn){
            return redirect()->back()->with('error', 'Please check your connection details and enter the correct values');
        }
    
        $result = sqlsrv_query($conn, $statement );
        if(!$result){
            return redirect()->back()->with('error', 'Please enter a valid SQL Query');
        }
        else {
            while( $item = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
                $string[] = implode( ", ", $item );
            }
            $diffs = array_diff($string,$value);
            foreach($diffs as $diff){
                DB::table('value_list_items')->insert(
                    ['value_list_id' => $vlist, 'name' => $diff]
                );
            }
        }
        return redirect()->back()->with('success', 'Value list was refreshed successfully');
     
    }

}
