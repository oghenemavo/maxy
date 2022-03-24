<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    
    public $guarded = ['id'];

    
    public function users()
    {
        
        return $this->belongsToMany('App\Models\User')->withPivot('can_read', 'can_write', 'can_checkin', 'can_download', 'can_share', 'can_lock', 'can_force_checkin');
    }

    
    public function groups()
    {
        
        return $this->belongsToMany('App\Models\Group')->withPivot('can_read', 'can_write', 'can_checkin', 'can_download', 'can_share', 'can_lock', 'can_force_checkin');;
    }

    public function tags()
    {
    	
    	return $this->belongsToMany('App\Models\Tag');
    }


    public function parent()
    {
    	
    	return $this->belongsTo('App\Models\Folder', 'parent_id');
    }

    public function workflow()
    {
        
        return $this->belongsTo('App\Models\Workflow', 'workflow_id');
    }

    public function children()
    {
        
        return $this->hasMany('App\Models\Folder', 'parent_id');
    }

     public function files()
    {
        
        return $this->hasMany('App\Models\File', 'folder_id')->where('uncategorized', 0);
    }

    public function fields()
    {

        return $this->belongsToMany('App\Models\UserField','folder_user_field')
          ->withPivot('folder_user_field_id')->orderBy('folder_user_field.folder_user_field_id');
    }

    public function createdByUser()
    {
        
        return $this->belongsTo('App\Models\User', 'created_by');
    }


    
}
