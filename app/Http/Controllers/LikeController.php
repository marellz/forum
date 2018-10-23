<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Like;
use App\Notify;

use Auth;

class LikeController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  //like/unlike a thread
  public function like($code)
  {
    $user = Auth::user();
    $user_likes = Like::where('item',$code)->where('user',$user->id);
    if(!$user_likes->first()){
      //create
      $like_code = str_random(10);
      Like::create([
        'code'=>$like_code,
        'user'=>$user->id,
        'item'=>$code,
      ]);

      //notify
      $if_thread = Thread::where('code',$code)->count()>0;
      $if_reply = Reply::where('code',$code)->count()>0;
      $type = $if_thread ? 'thread' : $if_reply ? 'reply' : 'unknown';
      $this->notify('like', $user->id, $type, $code, false);
      return response()->json(['liked'=>true]);

    } else {
      //delete
      $user_likes->delete();

      //delete notification
      Nofify::where('targetCode',$user_likes->first()->code)->delete();

      return response()->json(['liked'=>false]);
    }

  }
}
