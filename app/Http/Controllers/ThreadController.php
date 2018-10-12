<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\ThreadFollow;
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
    $user = Auth::user()->id;

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
    $thread->user = User::find($thread->user);
    $thread->timing = $thread->created_at->diffForHumans();
    $thread->likes = Like::where('item',$thread->code)->count();
    $thread->liked = Auth::check() && Like::where('item',$thread->code)->where('user',Auth::user()->id)->count()>0;
    $thread->follows = Auth::check() && ThreadFollow::where('thread',$code)->where('user',Auth::user()->id)->count();
    $thread->follow_count = ThreadFollow::where('thread',$code)->count();
    $thread->isOwner = Auth::check() && $thread->user->email == Auth::user()->email;

    $replies = Reply::where('thread',$code)->get();
    foreach ($replies as $key => $reply) {
      $reply->likes = Like::where('item',$reply->code)->count();
      $reply->liked = Auth::check() && count(Like::where('item',$reply->code)->where('user',Auth::user()->email)->get())>0;
      $reply->user = User::find($reply->user);
      $reply->isOwner = Auth::check() && $reply->user->email == Auth::user()->email;
      $reply->timing = $reply->created_at->diffForHumans();
    }

    return response()->json(['thread'=>$thread,'replies'=>$replies]);


    // return view('thread.view',compact(['thread','replies','isAuthenticated']));
  }

  public function follow($code)
  {
    $user_id = Auth::user()->id;
    if(Thread::where('code',$code)->first()->user == $user_id){
      //you can't follow your own thread, fam
      return response()->json(['success'=>false,'message'=>'Thou shalt not follow their own thread.']);
    }

    $follows = ThreadFollow::where('thread',$code)->where('user',$user_id)->count()>0;
    if($follows){
      ThreadFollow::where('thread',$code)->where('user',$user_id)->delete();
      $now_follows = false;
    } else {
      ThreadFollow::create([
        'thread'=>$code,
        'user'=>$user_id,
      ]);
      $now_follows = true;
    }

    return response()->json(['success'=>true,'follows'=>$now_follows]);
  }

  public function delete($code)
  {
    //delete all replies, subreplies, likes partaining to
    //this thread
    Thread::where('code',$code)->delete();
  }
}
