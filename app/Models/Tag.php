<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Tag extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'details', 'parent_id'
    ];

    
    public function files()
    {
        return $this->belongsToMany('App\Models\File');
    }

}
