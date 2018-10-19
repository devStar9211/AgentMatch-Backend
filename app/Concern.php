<?php

namespace agent_match;

use Illuminate\Database\Eloquent\Model;
use agent_match\User;

class Concern extends Model
{
    //
  public function get_concern($user_id, $target_id) {
    return $this -> where('user_id', $user_id) -> where('target_id', $target_id);
  }
  public function user() {
    return $this -> belongsTo(User::Class);
  }
}
