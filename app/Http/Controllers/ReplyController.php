<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Thread;
use App\User;
use App\Like;

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
        'user'=>Auth::user()->email,
        'thread'=> $code,
        'content'=>$request->input('reply'),
      ]);

      $reply->likes = Like::where('item',$reply->code)->count();
      $reply->liked = Auth::check() && count(Like::where('item',$reply->code)->where('user',Auth::user()->email)->get())>0;
      $reply->user = User::where('email',$reply->user)->first();
      $reply->isOwner = Auth::check() && $reply->user->email == Auth::user()->email;
      $reply->timing = $reply->created_at->diffForHumans();

      return response()->json(['success'=>true,'reply'=>$reply]);

      // return redirect()->back()->with('message','Reply added.');
    }

    public function delete(Request $request,$code)
    {
      Reply::where('code',$code)->delete();
      return response()->json(['deleted'=>true]);
    }
}
