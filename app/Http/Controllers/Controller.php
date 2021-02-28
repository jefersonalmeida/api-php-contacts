<?php

namespace Jas\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Artisan;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function welcome()
    {
        return view('welcome');
    }

    public function routes(): string
    {
        Artisan::call('route:list --path=api');
        return '<pre>' . Artisan::output() . '</pre>';
    }

}
