<?php

namespace agent_match;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    //
  protected $fillable = [
        'email', 'token'
    ];
}
