<?php

namespace agent_match;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
   protected $fillable = [
    'user_id', 'profileLink', 'isConsult', 'location', 'portfollio'
  ];
}
