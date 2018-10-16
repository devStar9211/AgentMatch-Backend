<?php

namespace agent_match;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    //
  protected $fillable = [
    'user_id', 'target_id'
  ];
}
