<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
trait functions {
  public function test(){
    return true;
  }
}
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, functions;
}
