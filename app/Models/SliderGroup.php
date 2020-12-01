<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Osi\LaravelControllerTrait\Models\FilterAndSorting;

class SliderGroup extends Model
{
    use FilterAndSorting;
    protected $guarded = [];
    public function slider()
    {
        return $this->hasMany('App\Models\Slider');
    }
}
