<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Osi\LaravelControllerTrait\Traits\ControllerBaseTrait;

class CategoryController extends Controller
{
    use ControllerBaseTrait;
    public function __construct(Category $model)
    {
        $this->model = $model;
        $this->resource = '\Osi\LaravelControllerTrait\Resources\Resource';
        $this->collection = '\Osi\LaravelControllerTrait\Resources\Collection';
        $this->functions = get_class_methods(self::class);
        // $this->rulePostfix = 'Rule';
    }
    public function tree(Request $request)
    {
        $data = $this->model->setFilterAndRelationsAndSort($request)->get()->toArray();
        $res = makeTree($data);
        return $this->dataSuccess($res);
    }
}
