<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class WorkflowStepTrigger extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'workflow_step_id', 'user_field_id', 'rank', 'operator', 'value', 'option', 'new_step_id'
    ];

    

    public function workflowStep()
    {
        return $this->belongsTo('App\Models\WorkflowStep');
    }

    public function newStep()
    {
        return $this->belongsTo('App\Models\WorkflowStep', 'new_step_id');
    }


    public function userField()
    {
        return $this->belongsTo('App\Models\UserField', 'user_field_id');
    }

    


    

}
