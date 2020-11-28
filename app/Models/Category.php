<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Osi\LaravelControllerTrait\Models\FilterAndSorting;

class Category extends Model
{
    use FilterAndSorting;
    protected $guarded = [];
    //
}
