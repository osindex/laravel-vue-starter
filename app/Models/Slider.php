<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Osi\LaravelControllerTrait\Models\FilterAndSorting;

class Slider extends Model
{
    use FilterAndSorting;
    protected $fillable = [
        'id',
        'group_id',
        'published_at',
        'title',
        'cover',
        'url',
        'description',
        'sequence',
        'state',
    ];
    // protected $casts = [
    //     'published_at' => 'datetime:Y-m-d H:i:s',
    // ];
    // // dates 产生时区问题
    // protected $dates = [
    //     'published_at',
    // ];
}
