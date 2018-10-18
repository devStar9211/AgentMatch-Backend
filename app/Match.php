<?php

namespace agent_match;

use Illuminate\Database\Eloquent\Model;

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
}
