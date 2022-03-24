<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherFiles extends Model
{
    public $guarded = ['id'];

    
    public function file()
    {
    	return $this->belongsTo('App\Models\File');
    }

    public function createdBy()
    {
    	return $this->belongsTo('App\Models\User', 'created_by');
    }

}
