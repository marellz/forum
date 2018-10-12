<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThreadFollow extends Model
{
  protected $fillable = [
    'user','thread'
  ];
}
