<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Group extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'details', 'is_active'
    ];

    
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_group');
    }

}
