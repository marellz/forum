<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResetTokens extends Model
{
    //
    protected $fillable = ['email','token','used'];
}
