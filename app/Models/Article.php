<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Osi\LaravelControllerTrait\Models\FilterAndSorting;

class Article extends Model
{
    use FilterAndSorting;
    protected $guarded = [];
    public $latestIndex = true;
    protected $filterScopes = ['major'];
    public function scopeMajor($query, $param)
    {
        // ->where('user_type', 'student')
        return $query->whereHas('student', function ($q) use ($param) {
            $q->where('major', $param);
        });
    }
}
