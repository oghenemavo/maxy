<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class WorkflowStep extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'rank', 'workflow_id'
    ];

    
    public function workflow()
    {
        return $this->belongsTo('App\Models\Workflow');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\WorkflowStepNotification');
    }

    public function triggers()
    {
        return $this->hasMany('App\Models\WorkflowStepTrigger')->orderBy("rank", 'desc');
    }

    public function combinedTriggers()
    {
        return $this->hasMany(WorkflowStepCombinedTrigger::class)->orderBy("rank", 'desc');
    }

    public function preConditions()
    {
        return $this->hasMany('App\Models\WorkflowStepCondition')->where('mode', 'PRE');
    }


    public function postConditions()
    {
        return $this->hasMany('App\Models\WorkflowStepCondition')->where('mode', 'POST');
    }

    public function assignees()
    {
        return $this->hasMany('App\Models\WorkflowStepAssignee');
    }
    
    public function metadata()
    {
        return $this->belongsToMany('App\Models\UserField', 'workflow_step_metadatas', 'workflow_step_id', 'user_field_id');
    }

}
