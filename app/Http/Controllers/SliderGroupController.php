<?php

namespace App\Http\Controllers;

use App\Models\SliderGroup;
use Illuminate\Http\Request;
use Osi\LaravelControllerTrait\Traits\ControllerBaseTrait;
class SliderGroupController extends Controller
{
    use ControllerBaseTrait;
    function __construct(SliderGroup $model) {
     $this->model = $model;
     $this->resource = '\Osi\LaravelControllerTrait\Resources\Resource';
     $this->collection = '\Osi\LaravelControllerTrait\Resources\Collection';
     $this->functions = get_class_methods(self::class);
     // $this->rulePostfix = 'Rule';
    }
}
