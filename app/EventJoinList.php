<?php

namespace agent_match;

use Illuminate\Database\Eloquent\Model;

class EventJoinList extends Model
{
    //
  public function event_time() {
    return $this->belongsTo('agent_match\EventTime');
  }

  public function event() {
    return $this->belongsTo('agent_match\EventTime');
  }
}
