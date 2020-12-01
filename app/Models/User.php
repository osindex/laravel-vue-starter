<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Osi\LaravelControllerTrait\Models\FilterAndSorting;
use Spatie\Tags\HasTags;

class User extends Authenticatable
{
    use Notifiable, FilterAndSorting, HasTags;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 获取指定用户的所有部门
     */
    public function depts()
    {
        return $this->morphToMany('App\Models\Dept', 'user', 'dept_user');
    }
}
