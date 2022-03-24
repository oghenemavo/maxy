<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\TasksLog;
use App\Models\User;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Collection;


class AuditsController extends Controller
{
    
    public function index (Request $request){

    	$users = User::get();

        $type='';
        $mainTab = 'users';
        
    	return view('audits.index', compact('users', 'type', 'mainTab'));
    }


    public function tableData(Request $request)
    {

    	$audits = ActivityLog::with('user');;

        if($request->dateRange){
            $arr = explode(" - ", $request->dateRange);
            $start = date('Y-m-d', strtotime($arr[0]))." 00:00:00";
            $end = date('Y-m-d', strtotime($arr[1]))." 23:59:59";

            // dump($start);
            // dd($end);

            $audits->whereBetween('created_at', [$start, $end]);

            
        }


    	switch ($request->user_id) {
    		case '0':

    			break;
    		default:
    			$audits = $audits->where('causer_id', $request->user_id);
    			break;
    	}


    	switch ($request->type) {
    		case 'files':
    			$audits = $audits->whereIn('actionable_type', ['App\Models\File', 'App\Models\Folder'] );
    			break;
    		case 'others':
    			$audits = $audits->whereNotIn('actionable_type', ['App\Models\File', 'App\Models\Folder'] );
    			break;
    		
    		default:
    			# code...
    			break;
    	}

        $logs = $audits->orderBy('created_at', 'desc')->get();

    	return view('common.audit-item', compact('logs'));
    }

    public function export($user_id, $type='', $date=''){

        // dd($date);
        $audits = ActivityLog::with('user')->orderBy('actionable_id', 'asc')->orderBy('created_at', 'asc')->get();

        // dd($date);
        
        if($date){
            $arr = explode(" - ", $date);
            $start = date('Y-m-d', strtotime($arr[0]))." 00:00:00";
            $end = date('Y-m-d', strtotime($arr[1]))." 23:59:59";
            
            // dump($start);
            // dd($end);
            
            $audits = $audits->whereBetween('created_at', [$start, $end]);
            $audits = $audits;
            // dd($audits);

            
        }

        switch ($user_id) {
            case '0':

                break;
            default:
                $audits = $audits->where('causer_id', $user_id);
                break;
        }


        switch ($type) {
            case 'files':
                $audits = $audits->whereIn('actionable_type', ['App\Models\File'] );
                // $audits = $audits->whereIn('actionable_type', ['App\Models\File', 'App\Models\Folder'] );
                break;
            case 'others':
                $audits = $audits->where('actionable_type', '!=', 'App\Models\File');
                break;
            
            default:
                # code...
                break;
        }
        $lags = []; 
        foreach($audits as $audit) {
            // dd($audit);
            $datetime = explode(" ",$audit->created_at);
            $action = new TasksLog;
            $action->ID = $audit->actionable_id;
            $action->User = $audit->user->full_name;
            $action->Description = $audit->description;
            $action->Date = $datetime[0];
            $action->Time = $datetime[1];
            $action->Action = $audit->action;
            // if($audit->actionable_type == 'App\Models\File') {
                //     $action->type = 'File';
                // }else if($audit->actionable_type == 'App\Models\Folder') {
                    //     $action->type = 'Folder';
                    // }
            $lags[] = $action;
        }
        $logs = new Collection($lags);
        // dd($logs);
        


        Excel::create('Audit-Export'.date('Y-m-d_h-m-s'), function($excel) use($logs) {
            $excel->setTitle('Audit Trail');
            $excel->sheet('Audit-Export', function($sheet) use($logs) {
                $sheet->fromArray($logs);
            });
        })->download('xlsx');
        
        log_action(Auth::id(), 'Audit trail export', 'App\Models\User', Auth::id(), 'Audit trail exported.');


        return redirect()->back();

    }

    public function details(Request $request, $logId)
    {
        $audit = ActivityLog::find($logId);

        return view('audits.details', compact('audit'));
    }


}
