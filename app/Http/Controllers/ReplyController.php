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
      $reply = Reply::create([
        'code'=>$reply_code,
        'user'=>Auth::user()->id,
        'thread'=> $code,
        'content'=>$request->input('reply'),
      ]);

      $reply->likes = Like::where('item',$reply->code)->count();
      $reply->liked = Auth::check() && count(Like::where('item',$reply->code)->where('user',Auth::user()->id)->get())>0;
      $reply->user = User::find($reply->user);
      $reply->isOwner = Auth::check() && $reply->user->email == Auth::user()->email;
      $reply->timing = $reply->created_at->diffForHumans();

      //notify
      $notify_code = str_random(15);
      $thread_creator = Thread::where('code',$code)->first()->user;
      $notification_source = $reply->user->id;
      if($thread_creator != $notification_source){
        Notify::create([
          'code'=>$notify_code,
          'type'=>'reply',
          'thread'=>$code,
          'from'=>$notification_source,
          'to'=>$thread_creator,
          'url'=>route('view-thread',['code'=>$code]),
          'read'=>false,
        ]);
      }
      return response()->json(['success'=>true,'reply'=>$reply]);
    }

    public function delete(Request $request,$code)
    {
      Reply::where('code',$code)->delete();
      return response()->json(['deleted'=>true]);
    }
}
