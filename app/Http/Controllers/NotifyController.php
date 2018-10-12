<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notify;
use App\Thread;
use App\User;
use Auth;

class NotifyController extends Controller
{
    //
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function fetch()
    {
      //should fetch for current User
      $notifications = Notify::where('to',Auth::user()->id)
      ->limit(7)
      ->latest()
      ->get();

      foreach ($notifications as $key => $not) {
        $from = User::find($not->from)->name;
        $src = $not->thread ? 'your thread <b>'. Thread::where('code',$not->thread)->first()->title.'</b>' : 'that';
        switch (($not->type)) {
          case 'like':
            $not->content = $from.' liked '.$src;
            break;
          case 'reply':
            $not->content = $from.' replied to '.$src;
            break;

          default:
            $not->content = 'You have a notification.';
            break;
        }
        $not->timing = $not->created_at->diffForHumans();
      }

      return response()->json(['success'=>true,'notifications'=>$notifications]);

    }

    public function action($code)
    {
      //when a user clicks on a notification
      $notif_pointer = Notify::where('code',$code);
      $notification = $notif_pointer->first();
      $notif_pointer->update(['read'=>true]);

      //lead me to that thread
      return redirect()->route('view-thread',['code'=>$notification->thread]);

    }


    public function markAsRead($code){
      Notify::where('code',$code)->update(['read'=>true]);
      return response()->json(['success'=>true]);
    }

    public function delete($code)
    {
      Notify::where('code',$code)->delete();
      return response()->json(['success'=>true]);
    }
}
