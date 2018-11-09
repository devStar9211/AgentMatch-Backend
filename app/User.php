<?php

namespace agent_match;

use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    //
  use HasApiTokens, Notifiable;
  protected $fillable = [
    'firstName', 'firstNameFuri', 'lastName', 'lastNameFuri','birthday',  'gender', 'schoolType', 'schoolName', 'literaryType', 'faculty', 'subject', 'gradDate', 'email','password','userType'
  ];

  public function user_with_token($token) {
    return $this->where('remember_token', $token);
  }

  public function profile() {
    return $this->hasOne('agent_match\Profile');
  }

  public function concern() {
    return $this->hasMany('agent_match\Concern');
  }


  public function rollApiKey(){
    $this->remember_token = str_random(20);

    $this->save();
    return $this->remember_token;
  }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function role() {
      return $this->belongsTo(Role::class);
    }

}
