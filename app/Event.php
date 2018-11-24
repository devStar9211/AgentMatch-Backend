<?php

namespace agent_match;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
  public function event_times() {
    return $this->hasMany('agent_match\EventTime');
  }

  public function event_join_users() {
    return $this -> hasMany('agent_match\EventJoinList');
  }

}
