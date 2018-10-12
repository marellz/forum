<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Thread;
use App\User;
use App\Like;
use App\Notify;

use Auth;

class ReplyController extends Controller
{
  //
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function create(Request $request,$code)
  {
    $reply_code = str_random(12);
    $thread = Thread::where('code',$code)->first();
    $user = Auth::user()->id;
    $reply = Reply::create([
      'code'=>$reply_code,
      'user'=>$user,
      'thread'=> $code,
      'content'=>$request->input('reply'),
    ]);

    $reply->likes = Like::where('item',$reply->code)->count();
    $reply->liked = Auth::check() && count(Like::where('item',$reply->code)->where('user',Auth::user()->id)->get())>0;
    $reply->user = User::find($reply->user);
    $reply->isOwner = Auth::check() && $reply->user->email == Auth::user()->email;
    $reply->timing = $reply->created_at->diffForHumans();

    $this->notify('reply',$user,$thread->user,'thread',$code,$thread->name);

    return response()->json(['success'=>true,'reply'=>$reply]);
  }

  public function delete(Request $request,$code)
  {
    Reply::where('code',$code)->delete();
    return response()->json(['deleted'=>true]);
  }
}
