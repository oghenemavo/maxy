<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class ValueListItem extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    public function valueList()
    {
        return $this->belongsTo('App\Models\ValueList');
    }
    
    
}
