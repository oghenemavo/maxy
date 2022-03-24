<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class WorkflowStepNotification extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'workflow_step_id', 'recipient_type', 'recipient_id', 'template'
    ];

    
    public function step()
    {

        return $this->belongsTo('App\Models\WorkflowStep', 'workflow_step_id');
    }

    

}
