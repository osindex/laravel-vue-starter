<?php

namespace App\Http\Controllers;

use App\Models\Dept;
use Illuminate\Http\Request;
use Osi\LaravelControllerTrait\Traits\ControllerBaseTrait;

class DeptController extends Controller
{
    use ControllerBaseTrait;
    public function __construct(Dept $model)
    {
        $this->model = $model;
        $this->resource = '\Osi\LaravelControllerTrait\Resources\Resource';
        $this->collection = '\Osi\LaravelControllerTrait\Resources\Collection';
        $this->functions = get_class_methods(self::class);
        // $this->rulePostfix = 'Rule';
    }
    public function tree(Request $request)
    {
        $data = $this->model->setFilterAndRelationsAndSort($request)->get();
        if ($request->appendTop) {
            foreach ($this->model->defaultOptions() as $option) {
                $data->prepend($option);
            }
        }
        $res = makeTree($data->toArray());
        return $this->dataSuccess($res);
    }
    public function user(Request $request)
    {
        // 方便权限处理
        $controller = resolve('\App\Http\Controllers\UserController');
        return $controller->index($request);
    }
    public function deptTag($data, $dept_id)
    {
        // $data = User::setFilterAndRelationsAndSort($request)->when($deptHas, function ($q) use ($deptHas) {
        //     $q->tagsWithType('dept')->withAnyTags([$deptHas]);
        // })->paginate((int) $request->pageSize ?? 15);
        // https://github.com/spatie/laravel-tags
        $data->syncTagsWithType([$dept_id], 'dept');
    }

    public function storeRule($request)
    {
        return $request->only(['parent_id', 'name', 'descrition', 'ordering']);
        // $validator = Validator::make($request->all(), $rules, $messages);
        // if ($validator->fails()) {
        //     throw new ValidationException($validator);
        // }
    }
}
