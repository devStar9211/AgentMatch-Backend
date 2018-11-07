<?php

namespace agent_match;

use Illuminate\Database\Eloquent\Model;
use agent_match\Message;

class Match extends Model
{
    //
  public function getStatus(int $id, int $target_id) {
    return $this->where(function($query) use($id, $target_id) {
      $query -> where('a_id', $id) -> where('b_id', $target_id);
    }) -> orWhere(function($query)  use($id, $target_id){
      $query -> where('b_id', $id) -> where('a_id', $target_id);
    });
  }

  public function get_match_list(int $user_id) {
    return $this->where('a_id', $user_id);
  }

  public function messages() {
    return $this->hasMany(Message::Class);
  }

  public function match_counts(int $id) {
    return $this->where('a_id', $id)->orWhere('b_id', $id)->count();
  }
}
