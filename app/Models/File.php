<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class File extends Model
{

    use SoftDeletes;

    
    
    public $guarded = ['id'];

    public $dates = ['last_modified'];

    
    public function users()
    {
    	
    	return $this->belongsToMany('App\Models\User')->withPivot('can_read', 'can_write', 'can_checkin', 'can_download', 'can_share', 'can_lock', 'can_force_checkin', 'is_following');
    }

     public function auth_user()
    {
        return $this->belongsToMany('App\Models\User')->withPivot('can_read', 'can_write', 'can_checkin', 'can_download', 'can_share', 'can_lock', 'can_force_checkin', 'is_following')->where('id', Auth::user()->id);
    }

    public function groups()
    {
    	
    	return $this->belongsToMany('App\Models\Group')->withPivot('can_read', 'can_write', 'can_checkin', 'can_download', 'can_share', 'can_lock', 'can_force_checkin');;
    }

    public function tags()
    {
    	
    	return $this->belongsToMany('App\Models\Tag');
    }




    public function folder()
    {
    	
    	return $this->belongsTo('App\Models\Folder');
    }


    public function versions()
    {
        
        return $this->hasMany('App\Models\Version');
    }
    
    public function otherFiles()
    {
        
        return $this->hasMany('App\Models\OtherFiles');
    }

    public function createdByUser()
    {
        
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    public function fields()
    {
        
        return $this->belongsToMany('App\Models\UserField')->withPivot('value')->withTimestamps(); 
    }

    public function step()
    {
        
        return $this->belongsTo('App\Models\WorkflowStep', 'workflow_step_id');
    }

    
}
