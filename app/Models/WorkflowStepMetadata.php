<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkflowStepMetadata extends Model
{
    //
    protected $fillable = [
        'id', 'user_field_id', 'workflow_step_id'
    ];

    public function step()
    {
        return $this->belongsTo('App\Models\WorkflowStep');
    }
    
    public function metadata()
    {
        return $this->belongsToMany('App\Models\UserField', 'workflow_step_id', 'user_field_id');
    }
}
