<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class WorkflowStepCondition extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'workflow_step_id', 'user_field_id', 'mode', 'operator', 'value', 'option'
    ];

    

    public function workflowStep()
    {
        return $this->belongsTo('App\Models\WorkflowStep');
    }


    public function userField()
    {
        return $this->belongsTo('App\Models\UserField', 'user_field_id');
    }

    


    

}
