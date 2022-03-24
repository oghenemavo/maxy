<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Workflow extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'is_active'
    ];

    
    public function folders()
    {
        return $this->hasMany('App\Models\Folder', 'workflow_id');
    }

    public function metadata()
    {
        return $this->belongsToMany('App\Models\UserField', 'workflow_user_field', 'workflow_id', 'user_field_id');
    }

    public function steps()
    {
        return $this->hasMany('App\Models\WorkflowStep')->orderBy('rank', 'asc');
    }

}
