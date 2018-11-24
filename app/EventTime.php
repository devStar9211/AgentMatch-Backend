<?php

namespace agent_match;

use Illuminate\Database\Eloquent\Model;

class EventTime extends Model
{
    //
  public function event() {
    return $this->belongsTo('agent_match\Event');
  }

  
}
