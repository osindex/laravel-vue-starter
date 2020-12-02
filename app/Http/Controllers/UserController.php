<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Osi\LaravelControllerTrait\Traits\ControllerBaseTrait;

class UserController extends Controller
{
    use ControllerBaseTrait;
    public function __construct(User $model)
    {
        $this->model = $model;
        $this->resource = '\Osi\LaravelControllerTrait\Resources\Resource';
        $this->collection = '\Osi\LaravelControllerTrait\Resources\Collection';
        $this->functions = get_class_methods(self::class);
        // $this->rulePostfix = 'Rule';
    }

    public function index(Request $request)
    {
        $deptHas = $request->get('deptHas', false);
        $data = $this->model->setFilterAndRelationsAndSort($request)
            ->when($deptHas, function ($q) use ($deptHas) {
                return $q->whereHas('depts', function ($query) use ($deptHas) {
                    $query->where('dept_id', $deptHas);
                });
            })
            ->paginate((int) $request->pageSize ?? 15);
        return new $this->collection($data);
    }
}
