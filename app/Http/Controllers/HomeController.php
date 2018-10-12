<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Thread;
use App\Reply;
use App\Like;

class HomeController extends Controller
{
  public function __construct()
  {

  }

  public function index(Request $request)
  {
    $threads = Thread::all();
    foreach ($threads as $key => $thread) {
      $thread->likes = Like::where('item',$thread->code)->count();
      $thread->reply_count = Reply::where('thread',$thread->code)->count();
    }
    return view('welcome',compact(['threads']));
  }

  public function search(Request $request)
  {
    $threads = Thread::all();
    $query = $request->input('q');
    return view('welcome',compact(['threads','query']));
  }

}
