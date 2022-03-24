<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Models\UserField;
use App\Models\Workflow;
use App\Models\WorkflowStep;
use App\Models\WorkflowStepAssignee;
use App\Models\WorkflowStepCombinedTrigger;
use App\Models\WorkflowStepCondition;
use App\Models\WorkflowStepNotification;
use App\Models\WorkflowStepTrigger;
use Auth;
use Illuminate\Http\Request;
use Session;

class WorkflowController extends Controller
{
    public function index()
    {
    	$workflows = Workflow::withCount('steps')->orderBy('name', 'asc')->get();
        $mainTab = 'file-controls';

    	return view('workflows.index', compact('workflows', 'mainTab'));
    }


    public function create(Request $request)
    {

    	$isEdit = false;

        
    	if($request->isMethod('post')){

    		$workflow = Workflow::FirstorCreate([ 'name' => $request->name, 'description' => $request->description ]);

            log_action(Auth::id(), 'Workflow Created', 'App\Models\Workflow', $workflow->id, $request->name.' workflow was created');


            return ['status' => '200', 'data' => $workflow ];
    	}


    	return view('workflows.create', compact('isEdit'));
    }


    public function view($id='')
    {
    	
    	$mainTab = 'file-controls';
        $workflow = Workflow::with(['steps' => function($q){ $q->orderBy('rank', 'asc'); },'metadata', 'folders'])
                ->withCount('steps', 'folders', 'metadata')->find($id);

        // dump($workflow->toArray());


    	return view('workflows.view', compact('workflow', 'mainTab'));
    }

    public function editMetadata(Request $request, $id)
    {
    	$workflow = Workflow::find($id);
    	$isEdit = true;

        

        
    	if($request->isMethod('post')){

            $workflow->metadata()->sync($request->fields);
            
    
            log_action(Auth::id(), 'Workflow Edited', 'App\Models\Workflow', $id, $request->name.' workflow was edited');

            Session::flash('success', 'Workflow metadata updated'); 

            return ['status' => '200', 'data' => $workflow ];
    	}

    	$workflow_fields = $workflow->metadata()->pluck('id')->toArray();
        $fields = UserField::pluck('name', 'id')->toArray();

        return view('workflows.metadata-edit', compact('workflow', 'isEdit', 'fields', 'workflow_fields'));
    }

    public function updateStep(Request $request, $workflow_id, $id = null)
    {
        
        if($id){
            $isEdit = true;
            $step = WorkflowStep::find($id);
        }else{
            $isEdit = false;
            $step = null;
        }

        
        if($request->isMethod('post')){

            $data = $request->only('name', 'description', 'workflow_id', 'rank');

            if($isEdit)
                $step->update( $data );
            else
                $step = WorkflowStep::FirstorCreate( $data );
            
    
            log_action(Auth::id(), 'Workflow Step Edited', 'App\Models\WorkflowStep', $step->id, $request->name.' workflow step was edited');

            Session::flash('success', 'Workflow step updated'); 

            return ['status' => '200', 'data' => $step ];
        }


        return view('workflows.update-step', compact('step', 'isEdit', 'workflow_id'));
    }


    public function edit(Request $request, $id)
    {
        $workflow = Workflow::find($id);
        $isEdit = true;
        
        if($request->isMethod('post')){

            $workflow->update([ 'name' => $request->name, 'description' => $request->description ]);
            
    
            log_action(Auth::id(), 'Workflow Metadata Edited', 'App\Models\Workflow', $id, $request->name.' workflow\'s metadata was edited');

            Session::flash('success', 'Workflow updated successfully'); 

            return ['status' => '200', 'data' => $workflow ];
        }

        return view('workflows.create', compact('workflow', 'isEdit'));
    }

    
    public function updateNotification(Request $request, $step_id, $id = null)
    {
        
        if($id){
            
            $isEdit = true;
            $notification = WorkflowStepNotification::find($id);
        }else{
            
            $isEdit = false;
            $notification = null;
        }

        $metaNames = "{{".implode("}}, {{", WorkflowStep::find($step_id)->workflow->metadata()->pluck('name')->toArray()) . "}}";
        $metaNames = strtolower($metaNames);

        
        if($request->isMethod('post')){

            $data = $request->only('recipient_id', 'template', 'workflow_step_id', 'recipient_type');
            if($isEdit)
                $notification->update( $data );
            else
                $notification = WorkflowStepNotification::FirstorCreate( $data );
            
    
            log_action(Auth::id(), 'Workflow notification updated', 'App\Models\WorkflowStepNotification', $notification->id, $request->name.' workflow notification was updated');

            Session::flash('success', 'Workflow notification updated'); 

            return ['status' => '200', 'data' => $notification ];
        }

        $users = User::pluck('first_name', 'id')->toArray();
        $default = [0 => 'Initiator'];
        $groups = Group::pluck('name','id')->toArray();
        $recipients = [
            'GROUP' => $groups,
            'USER' => $users,
            'DEFAULT' => $default
        ];


        return view('workflows.update-notification', compact('notification', 'isEdit', 'step_id', 'recipients', 'metaNames'));
    }

    public function updateAssignee(Request $request, $step_id, $id = null)
    {
        
        if($id){
            
            $isEdit = true;
            $ass = WorkflowStepAssignee::find($id);
        }else{
            
            $isEdit = false;
            $ass = null;
        }

        $metaNames = "{{".implode("}}, {{", WorkflowStep::find($step_id)->workflow->metadata()->pluck('name')->toArray()) . "}}";
        $metaNames = strtolower($metaNames);

        
        if($request->isMethod('post')){

            $data = $request->only('recipient_id', 'template', 'workflow_step_id', 'recipient_type');

            if($isEdit)
                $ass->update( $data );
            else
                $ass = WorkflowStepAssignee::FirstorCreate( $data );
            
    
            log_action(Auth::id(), 'Workflow assignee updated', 'App\Models\WorkflowStepAssignee', $ass->id, $request->name.' workflow assignee was updated');

            Session::flash('success', 'Workflow step assignee updated'); 

            return ['status' => '200', 'data' => $ass ];
        }

        $users = User::pluck('first_name', 'id')->toArray();
        $groups = Group::pluck('name','id')->toArray();
        $default = [0 => 'Initiator'];
        $recipients = [
          'GROUP' => $groups,
          'USER' => $users,
          'DEFAULT' => $default
        ];


        
        return view('workflows.update-ass', compact('ass', 'isEdit', 'step_id', 'recipients', 'metaNames'));
    }

    public function updateCondition(Request $request, $step_id, $mode, $id = null)
    {
        
        if($id){
            
            $isEdit = true;
            $condition = WorkflowStepCondition::find($id);
        }else{
            
            $isEdit = false;
            $condition = null;
        }

        
        if($request->isMethod('post')){

            $data = $request->only('user_field_id', 'operator', 'workflow_step_id', 'value1', 'value2', 'mode', 'option');

            $data['value'] = (empty($data['value2'])) ? $data['value1'] : $data['value1'] . '::--::' . $data['value2'];

            unset($data['value1']);
            unset($data['value2']);

            if($isEdit)
                $condition->update( $data );
            else
                $condition = WorkflowStepCondition::FirstorCreate( $data );
            
    
            log_action(Auth::id(), 'Workflow condition updated', 'App\Models\WorkflowStepCondition', $condition->id, $request->name.' workflow condition was updated');

            Session::flash('success', 'Workflow step condition updated'); 

            return ['status' => '200', 'data' => $condition ];
        }

        $step = WorkflowStep::find($step_id);

        $fields = $step->workflow->metadata()->pluck('name', 'id')->toArray();

        
        return view('workflows.update-condition', compact('condition', 'isEdit', 'step_id', 'fields', 'mode'));
    }


    public function updateTrigger(Request $request, $step_id, $id = null)
    {
        
        if($id){
            
            $isEdit = true;
            $trigger = WorkflowStepTrigger::find($id);
        }else{
            
            $isEdit = false;
            $trigger = null;
        }


        if($request->isMethod('post')){

            $data = $request->only(
              'user_field_id', 'operator', 'workflow_step_id', 'value', 'option', 'rank', 'new_step_id', 'isdropdown',
              'value_drop'
            );
            if($data['isdropdown'] == '1') {
              $data['value'] = $data['value_drop'];
            }
            unset($data['isdropdown']);
            unset($data['value_drop']);

            if($isEdit)
                $trigger->update( $data );
            else
                $trigger = WorkflowStepTrigger::FirstorCreate( $data );
            
    
            log_action(Auth::id(), 'Workflow trigger updated', 'App\Models\WorkflowStepTrigger', $trigger->id, $request->name.' workflow trigger was updated');

            Session::flash('success', 'Workflow step trigger updated'); 

            return ['status' => '200', 'data' => $trigger ];
        }

        $step = WorkflowStep::find($step_id);
        $otherSteps = $step->workflow->steps()->where('id', '<>', $step_id)->pluck('name', 'id')->toArray();

        $fieldsArray = $step->workflow->metadata()->get();
        $fields = $fieldsArray->pluck('name', 'id')->toArray();
        $fieldsType =  $fieldsArray->pluck('type', 'id')->toArray();

        $valueLists = UserField::with('list','list.items')
          ->where('type', 'Dropdown')
          ->get();

        $valueListItems = [];
        foreach ($valueLists as $valueList) {
          if(!is_null($valueList->list))
            $valueListItems[$valueList->id] = $valueList->list->items->pluck('name')->toArray();
        }

        
        return view('workflows.update-trigger', compact(
          'trigger', 'isEdit', 'step_id', 'fields', 'otherSteps', 'fieldsType', 'valueListItems'
        ));
    }

    public function updateMetadata(Request $request, $step_id, $id = null)
    {
        
	$step = WorkflowStep::find($step_id);
        if($id){
            
            $isEdit = true;
            // $step = WorkflowStep::find($id);
        }else{
            
            $isEdit = false;
            // $stepMetadata= null;
        }

        if($request->isMethod('post')){

            $step->metadata()->sync($request->fields);
            
    
            log_action(Auth::id(), 'Workflow Step Metadata Updated', 'App\Models\WorkflowStepMetdata', $step_id, $request->name.' workflow step metadata was updated');

            Session::flash('success', 'Workflow metadata updated'); 

            return ['status' => '200', 'data' => $step ];
        }

        $step = WorkflowStep::find($step_id);
        $step_fields = $step->metadata()->pluck('id')->toArray();
        $fields = UserField::pluck('name', 'id')->toArray();

        return view('workflows.update-metadata', compact('isEdit', 'fields','step_id', 'step_fields', 'step'));
    }
    
    public function updateCombinedTrigger(Request $request, $step_id, $id = null)
    {
        if($id){
            $isEdit = true;
            $trigger = WorkflowStepCombinedTrigger::find($id);
        }else{
            $isEdit = false;
            $trigger = null;
        }

        if($request->isMethod('post')){
            $data = $request->only('user_field_id', 'operator', 'workflow_step_id', 'value', 'option', 'isdropdown',
              'value_drop');

          if($data['isdropdown'] == '1') {
            $data['value'] = $data['value_drop'];
          }
          unset($data['isdropdown']);
          unset($data['value_drop']);

            if($isEdit)
                $trigger->update( $data );
            else
                $trigger = WorkflowStepCombinedTrigger::FirstorCreate( $data );

            log_action(Auth::id(),
              'Workflow combined trigger updated',
              'App\Models\WorkflowStepCombinedTrigger',
              $trigger->id,
              $request->name.' workflow combined trigger was updated'
            );

            Session::flash('success', 'Workflow step combined trigger updated');

            return ['status' => '200', 'data' => $trigger ];
        }

        $step = WorkflowStep::find($step_id);
        $otherSteps = $step->workflow->steps()->where('id', '<>', $step_id)->pluck('name', 'id')->toArray();

        $fieldsArray = $step->workflow->metadata()->get();
        $fields = $fieldsArray->pluck('name', 'id')->toArray();
        $fieldsType =  $fieldsArray->pluck('type', 'id')->toArray();

        $valueLists = UserField::with('list','list.items')
          ->where('type', 'Dropdown')
          ->get();

        $valueListItems = [];
        foreach ($valueLists as $valueList) {
          if(!is_null($valueList->list))
            $valueListItems[$valueList->id] = $valueList->list->items->pluck('name')->toArray();
        }

        return view('workflows.update-combined-trigger', compact(
          'trigger', 'isEdit', 'step_id', 'fields', 'otherSteps', 'fieldsType', 'valueListItems'
        ));
    }

    public function combinedTriggerAction(Request $request, $step_id, $id = null)
    {
        $step = WorkflowStep::find($step_id);
        $combinedTriggers = $step->combinedTriggers;

        if($combinedTriggers->isEmpty()) {
            return ['status' => '200' ];
        }

        $trigger = $combinedTriggers->last();

        if($request->isMethod('post')){
            $data = $request->only('workflow_step_id', 'option', 'rank', 'new_step_id');

            $trigger->update($data);

            log_action(Auth::id(),
              'Workflow combined trigger updated',
              'App\Models\WorkflowStepCombinedTrigger',
              $trigger->id,
              $request->name.' workflow combined trigger was updated'
            );

            Session::flash('success', 'Workflow step combined trigger updated');

            return ['status' => '200', 'data' => $trigger ];
        }

        $step = WorkflowStep::find($step_id);
        $otherSteps = $step->workflow->steps()->where('id', '<>', $step_id)->pluck('name', 'id')->toArray();

        return view('workflows.combined-trigger-action', compact('trigger', 'step_id', 'otherSteps'));
    }

    public function delStep($stepId){

        WorkflowStep::find($stepId)->delete();

        return redirect()->back()->with('success', 'Step was deleted successfully.');

    }

    public function delAssignee($assId){

        WorkflowStepAssignee::find($assId)->delete();

        return redirect()->back()->with('success', 'Assignee was deleted successfully.');

    }

    public function delNotification($notifId){

        WorkflowStepNotification::find($notifId)->delete();

        return redirect()->back()->with('success', 'Notification was deleted successfully.');

    }

    public function delCondition($condId){

        WorkflowStepCondition::find($condId)->delete();

        return redirect()->back()->with('success', 'Condition was deleted successfully.');

    }

    public function delTrigger($condId){

        WorkflowStepTrigger::find($condId)->delete();

        return redirect()->back()->with('success', 'Trigger was deleted successfully.');

    }

    public function delMetadata($condId){

        WorkflowStepTrigger::find($condId)->delete();

        return redirect()->back()->with('success', 'Trigger was deleted successfully.');
    }
    public function delCombinedTrigger($condId){
        WorkflowStepCombinedTrigger::find($condId)->delete();
        return redirect()->back()->with('success', 'Combined Trigger was deleted successfully.');
    }



}
