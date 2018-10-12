<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    //
    protected $fillable = [
      'code',
      'action',
      'trigger', //user id
      'recipient', //thread/reply owner
      'targetType', //thread/reply
      'targetCode', //thread/reply code
      'targetName', //thread name, if thread

      'read',
    ];
}
