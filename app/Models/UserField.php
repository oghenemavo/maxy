<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class UserField extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'title', 'type', 'value_list_id'
    ];

    
    public function folders()
    {
        
        return $this->belongsToMany('App\Models\Folder');
    }

    public function list(){

        return $this->belongsTo('App\Models\ValueList', 'value_list_id');
    }

}
