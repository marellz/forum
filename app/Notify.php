<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    //
    protected $fillable = [
      'code',
      'type', //like,reply
      'from', //user that triggered it
      'to', //user that owns the thread
      'thread', //thread it was triggered on
      'content', //content, if not thread-based
      'url', // url to go to, if not thread-based
      'read', //read status
    ];
}
