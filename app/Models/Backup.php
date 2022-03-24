<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Backup extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'file', 'created_by', 'status'
    ];

    
    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

}
