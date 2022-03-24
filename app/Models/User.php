<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name', 'first_name', 'username', 'staff_id', 'is_active', 'must_change_password', 'email_verified_at', 'email', 'password', 'access_type', 'session_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getFullNameAttribute()
    {
         return strtoupper($this->last_name).' '.$this->first_name;
    }

    public function groups()
    {
        return $this->belongsToMany('App\Models\Group', 'user_group');
    }

    public function favourites()
    {
        return $this->belongsToMany('App\Models\File', 'favourites')->withTimestamps();   
    }

    public function logs()
    {
        return $this->hasMany('App\Models\ActivityLog', 'causer_id');
    }

    public function files()
    {
        
        return $this->belongsToMany('App\Models\File')->withPivot('can_read', 'can_write', 'can_checkin', 'can_download', 'can_share', 'can_lock', 'can_force_checkin', 'is_following');
    }
}
