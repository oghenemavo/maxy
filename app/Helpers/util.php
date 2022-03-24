<?php

	use App\Models\ActivityLog;
	use App\Models\Folder;
	use App\Models\Group;
	use App\Models\Setting;
	use App\Models\User;
	use App\Models\WorkflowStep;
	use App\Notifications\FileUpdate;
	use Illuminate\Support\Str;

	// use App\Models\File;


    function log_action($user_id, $log_name, $actionable_type, $action_id, $details, $action='')
	{
		
		$log = ActivityLog::create([
			'causer_id' => $user_id,
			'log_name' => $log_name,
			'description' => $details,
			'actionable_id' => $action_id,
			'actionable_type' => $actionable_type,
			'ip' => request()->server('SERVER_ADDR'),
			'action' => $action,
		]);

		//sending notifications to followers...
		if($actionable_type ==  'App\Models\File'){

			$user_name = Auth::user()->full_name;

			$file = App\Models\File::with('users')->find($action_id);
			if($file){
				foreach ($file->users as $user) {
					if($user->pivot->is_following){
						$user->notify(new FileUpdate($file, $user_name.' '.$details, $user));
					}
				}
			}

		}

	}


	function sizeFilter( $bytes )
	{
	    $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
	    for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
	    return( round( $bytes, 2 ) . " " . $label[$i] );
	}

	function prepDropdownItemsFromCsv($csv, $mode = ""){

		if($mode == "All")
			$items[''] = " -All- ";
		elseif($mode == "")
			$items[''] = " -Choose- ";
		
			
		$arr = explode(",", $csv);
		foreach ($arr as $a) {
			$a = trim($a);
			$items[$a] = $a;
		}

		return $items;

	}
	
	function prepDropdownItemsFromMetadata($csv, $mode = ""){

		if($mode == "All")
					$items[''] = " -All- ";		
		elseif($mode == "")
			$items[''] = " -Choose- ";
		
		foreach ($csv as $a) {
			$a = trim($a);
			$items[$a] = $a;
		}

		return $items;

	}


    function prepDropdownItemsFromValueList($vlist, $mode = ""){

        if($mode == "All")
            $items[''] = " -All- ";
        elseif($mode == "")
            $items[''] = " -Choose- ";
        if(! is_null($vlist)) {
            if($vlist->type == 'LOCAL' || $vlist->type == 'EXCEL' ){
                foreach ($vlist->items as $item) {
                    $items[$item->name] = $item->name;
                }
            }elseif($vlist->type == 'PRE-DEFINED'){

                $model_name = $vlist->model;
				$all = $model_name::all();
                foreach ($all as $item) {
					if($item->name)
						$items[$item->name] = $item->name;
					else
					$items[$item->first_name .' '.$item->last_name] = $item->first_name .' '.$item->last_name;
                }

            }
        }
        

        return $items;

    }

	function site_logo(){

		return Setting::where('key', 'logo')->first()->value;

	}

	function settings(){

		return Setting::pluck('value', 'key')->toArray();
	}


	function getFolders(){

		return Folder::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
	}


	function format_type($type)
	{	
		$type = str_ireplace("vnd.openxmlformats-officedocument.wordprocessingml.document", "Word document", str_ireplace("application/", "", $type));

		$type = str_ireplace("vnd.openxmlformats-officedocument.spreadsheetml.sheet", "Excel Document", $type);
		return $type;
	}


	function uploadFile($file)
    {

    	$path = public_path('uploads');
   
	    if(!\File::isDirectory($path)){
	        \File::makeDirectory($path, 0777, true, true);
	    }

        $fileName = str_ireplace(' ', '', $file->getClientOriginalName());
        $filePath =  uniqid().'.'.\File::extension($file->getClientOriginalName());
        $file->move(env('UPLOAD_FILE_PATH', 'uploads/'), $filePath);

        $lastMod 	= \File::lastModified(env('UPLOAD_FILE_PATH', 'uploads/').$filePath);
        $size 		= \File::size(env('UPLOAD_FILE_PATH', 'uploads/').$filePath);
        $mimeType 	= \File::mimeType(env('UPLOAD_FILE_PATH', 'uploads/').$filePath);

        return compact('fileName', 'filePath', 'lastMod', 'size', 'mimeType');
    }

    function getUserName($userId){
		 
    	return User::find($userId)->full_name;
	}
	
    function getGroupName($groupId){
		 
    	return Group::find($groupId)->name;
    }


    function checkCondition($val, $operator, $opt1, $opt2 = ""){

    	switch ($operator) {
    		case 'equals':
    			return $val == $opt1;
    			break;
    		
    		case 'not equals':
    			return $val != $opt1;
    			break;
    		
    		case 'contains':
    			return Str::contains($val, $opt1);
    			break;
    		
    		case 'does not contains':
    			return !Str::contains($val, $opt1);
    			break;
    		
    		case 'starts with':
    			return Str::startsWith($val, $opt1);
    			break;
    		
    		case 'does not starts with':
    			return !Str::startsWith($val, $opt1);
    			break;
    		
    		case 'ends with':
    			return Str::endsWith($val, $opt1);
    			break;
    		
    		case 'does not ends with':
    			return !Str::endsWith($val, $opt1);
    			break;
    		
    		case 'is empty':
    			return empty(trim($val));
    			break;
    		
    		case 'is not empty':
    			return !empty(trim($val));
    			break;
    		
    		case '>':
    			return $val > $opt1;
    			break;
    		
    		case '>=':
    			return $val >= $opt1;
    			break;
    		
    		case '<':
    			return $val < $opt1;
    			break;
    		
    		case '<=':
    			return $val <= $opt1;
    			break;
    		
    		case 'between':
    			return $val >= $opt1 && $val <= $opt2;
    			break;
    		
    		case 'not between':
    			return !($val >= $opt1 && $val <= $opt2);
    			break;
    		
    		default:
    			return false;
    			break;
    	}

    }

    function getWorkflowStepConditions($step_id, $mode = "PRE"){

    	$step = WorkflowStep::with('preConditions', 'postConditions')->find($step_id);
        $str ="";


        if($mode == 'PRE')
            $conditions = $step->preConditions;
        else
            $conditions = $step->postConditions;

        // dump($step->toArray());

        foreach ($conditions as $condition) {
        	$str .= "Where ". $condition->userField->name .' '. $condition->operator.' '. str_ireplace("::--::", " and ", $condition->value)."<br/>"; 
        }

        return $str;

    	
    }

    function doStepNotification($file){

		$step = WorkflowStep::with('notifications')->find($file->workflow_step_id);
			
		foreach ($step->notifications as $notif) {
			if($notif->recipient_type == "DEFAULT"){
				$user = User::find($file->created_by);

				$message = getTemplateMessage($file, $notif, $step);

        		$user->notify(new FileUpdate($file, $message, $user, "STATE_NOTIFICATION"));
			}
    		
    		elseif($notif->recipient_type == "USER"){
    			$user = User::find($notif->recipient_id);

    			//populating the message template.
						$message = getTemplateMessage($file, $notif, $step);

        		$user->notify(new FileUpdate($file, $message, $user, "STATE_NOTIFICATION"));
    		
        	}
    		elseif ($notif->recipient_type = "GROUP") {
    		    $groupId = $notif->recipient_id;
                $groupUsers = Group::with('users')->find($groupId)->users;

                //populating the message template.
                $message = getTemplateMessage($file, $notif, $step);

                foreach ($groupUsers as $user) {
                    $user->notify(new FileUpdate($file, $message, $user, "STATE_NOTIFICATION"));
                }
            }
    	}

    }

    /**
     * @param $file
     * @param $notif
     * @param $step
     * @return array
     */
    function getTemplateMessage($file, $notif, $step) {
        $message = $notif->template;
        $meta = $step->workflow->metadata()->pluck('name', 'id')->toArray();
        foreach ($meta as $key => $value) {

            $fld = $file->fields()->where('id', $key)->first();
            // checking if value exist
            if ($fld) {
				$val = $fld->pivot->value;
				if($fld->type == "Number"){
					$val = number_format($fld->pivot->value);
				} 
				elseif($fld->type == "Decimal"){
					$val = number_format($fld->pivot->value, 2);
				}
			}
			else {
                $val = '';
            }
            $message = str_ireplace(strtolower("{{".$value."}}"), $val, $message);
        }
        return $message;
    }


    function doStepAssigneeNotification($file){

        $step = WorkflowStep::with('assignees')->find($file->workflow_step_id);
        foreach ($step->assignees as $notif) {
            if($notif->recipient_type == "DEFAULT"){
				$user = User::find($file->created_by);

				$message = getTemplateMessage($file, $notif, $step);

        		$user->notify(new FileUpdate($file, $message, $user, "STATE_ASSIGNEE"));
			}
			
			elseif($notif->recipient_type == "USER"){
                $user = User::find($notif->recipient_id);

                //populating the message template.
				$message = getTemplateMessage($file, $notif, $step);

                $user->notify(new FileUpdate($file, $message, $user, "STATE_ASSIGNEE"));
            
            }  elseif ($notif->recipient_type = "GROUP") {
                $groupId = $notif->recipient_id;
                $groupUsers = Group::with('users')->find($groupId)->users;

                //populating the message template.
								$message = getTemplateMessage($file, $notif, $step);

                foreach ($groupUsers as $user) {
                    $user->notify(new FileUpdate($file, $message, $user, "STATE_ASSIGNEE"));
                }
            }
        }

    }

 ?>
