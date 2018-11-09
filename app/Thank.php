<?php

namespace agent_match;

use Illuminate\Database\Eloquent\Model;

class Thank extends Model
{
    //
  protected $fillable = [
    'user_id', 'target_id', 'comment'
  ];

  function thanks_senders(int $id) {
    return $this -> where('target_id', $id) -> get();
  }

  function thanks_count(int $id) {
    return $this -> where('target_id', $id) -> count();
  }
}
