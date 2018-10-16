<?php

namespace agent_match;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
  public function users() {
    return $this->hasMany('agent_match\User')->orderBy('index');
  }
}
