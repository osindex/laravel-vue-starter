<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Osi\LaravelControllerTrait\Models\FilterAndSorting;

class Article extends Model
{
    use FilterAndSorting;
    protected $guarded = [];
    //
}
