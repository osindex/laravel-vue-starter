<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Osi\LaravelControllerTrait\Traits\ResponseBaseTrait;
use Overtrue\LaravelUploader\StrategyResolver;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ResponseBaseTrait;

    public function upload(Request $request)
    {
        return $this->dataSuccess(StrategyResolver::resolveFromRequest($request, $request->get('strategy', 'default'))->upload());
    }
}
