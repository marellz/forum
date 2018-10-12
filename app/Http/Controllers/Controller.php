<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Notify;
use Auth;

trait functions {
  public function test()
  {
    return true;
  }
  public function notify($action,$from,$to,$type,$code,$name)
  {
    //notify
    if(!Auth::check()){
      return false;
    }
    $notify_code = str_random(15);

    if($from == $to ){
      return false;
    }

    $notification = Notify::create([
      'code'=>$notify_code,
      'action'=>$action,
      'trigger'=>$from,
      'recipient'=>$to,
      'targetType'=>$type,
      'targetCode'=>$code,
      'targetName'=>$name,
    ]);

    return $notification;

  }
}


class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests, functions;
}
