<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Like;

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
      return response()->json(['liked'=>true]);

    } else {
      //delete
      $user_likes->delete();
      return response()->json(['liked'=>false]);
    }

  }
}
