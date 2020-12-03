<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Osi\LaravelControllerTrait\Models\FilterAndSorting;

class Dept extends Model
{
    use FilterAndSorting;
    protected $guarded = [];
    public $latestIndex = false;
    public function defaultOptions()
    {
        return [
            [
                'id' => 0,
                'name' => '顶级机构',
                'parent_id' => 0,
            ],
        ];
    }

    /**
     * 获取所有分配该部门的用户
     */
    public function users()
    {
        return $this->morphedByMany('App\Model\User', 'user');
    }
    /**
     * 获取所有分配该部门的管理用户
     */
    public function adminUsers()
    {
        return $this->morphedByMany('App\Model\AdminUser', 'user');
    }
}
