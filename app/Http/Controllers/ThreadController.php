<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\User;
use App\Reply;
use App\Like;

use Auth;
use Carbon;
class ThreadController extends Controller
{
  //
  public function __construct()
  {
    $this->middleware('auth',['except'=>['view','fetch']]);
  }

  public function create(Request $request)
  {
    $code = str_random(10);
    $user = Auth::user()->email;

    $thread = Thread::create([
      'code'=>$code,
      'user'=>$user,
      'title'=>$request->input('title'),
      'content'=>$request->input('content'),
      'closed'=>false,
    ]);

    return redirect()->route('view-thread',['code'=>$thread->code]);
  }

  public function view($code){
    return view('thread.view',compact(['code']));
  }

  public function fetch($code)
  {
    $thread = Thread::where('code',$code)->first();
    if(!$thread){
      return response()->json(['error'=>'Does not exist']);
    }
    $thread->user = User::where('email',$thread->user)->first();
    $thread->timing = $thread->created_at->diffForHumans();
    $thread->likes = Like::where('item',$thread->code)->count();
    $thread->liked = Auth::check() && count(Like::where('item',$thread->code)->where('user',Auth::user()->email)->get())>0;
    $thread->isOwner = Auth::check() && $thread->user->email == Auth::user()->email;

    $replies = Reply::where('thread',$code)->get();
    foreach ($replies as $key => $reply) {
      $reply->likes = Like::where('item',$reply->code)->count();
      $reply->liked = Auth::check() && count(Like::where('item',$reply->code)->where('user',Auth::user()->email)->get())>0;
      $reply->user = User::where('email',$reply->user)->first();
      $reply->isOwner = Auth::check() && $reply->user->email == Auth::user()->email;
      $reply->timing = $reply->created_at->diffForHumans();
    }

    return response()->json(['thread'=>$thread,'replies'=>$replies]);


    // return view('thread.view',compact(['thread','replies','isAuthenticated']));
  }

  public function delete($code)
  {
    //delete all replies, subreplies, likes partaining to
    //this thread
    Thread::where('code',$code)->delete();
  }
}
