<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Osi\LaravelControllerTrait\Models\FilterAndSorting;

class SliderGroup extends Model
{
    use FilterAndSorting;
    protected $fillable = [
        'cover',
        'description',
        'sequence',
        'title',
        'options',
    ];
    protected $casts = [
        'options' => 'json',
    ];
    public function slider()
    {
        return $this->hasMany('App\Models\Slider', 'group_id');
    }
}
