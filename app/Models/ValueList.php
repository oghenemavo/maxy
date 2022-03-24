<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class ValueList extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    
    public function items()
    {
        return $this->hasMany('App\Models\ValueListItem');
    }

}
