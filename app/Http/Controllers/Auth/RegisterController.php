<?php

namespace agent_match\Http\Controllers\Auth;

use agent_match\User;
use agent_match\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use agent_match\Jobs\SendVerificationEmail;
use Debugbar;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm($role_id)
    {

      return view('auth.register')->with('role_id',$role_id);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
      return Validator::make($data, [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
      ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \agent_match\User
     */
    protected function create(array $data)
    {
      $user = User::create([
        'firstName' => $data['firstName'],
        'firstNameFuri' => $data['firstNameFuri'],
        'lastName' => $data['lastName'],
        'lastNameFuri' => $data['lastNameFuri'],
        'birthday' => $data['birthday'],
        'gender' => $data['gender'],
        'schoolType' => $data['schoolType'],
        'schoolName' => $data['schoolName'],
        'literaryType' => $data['literaryType'],
        'faculty' => $data['faculty'],
        'subject' => $data['subject'],
        'gradDate' => $data['gradDate'],
        'email' => $data['email'],
        'email_token' => base64_encode($data['email']),
        'password' => Hash::make($data['password']),
        'role_id' => (int)$data['role_id'],
      ]);
      return $user;
    }

    public function register(Request $request)
    {
      $this->validator($request->all())->validate();
      event(new Registered($user = $this->create($request->all())));

      dispatch(new SendVerificationEmail($user));
      return response("ok", 200)
                      -> header('Content-Type', 'text/plain');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function verify($token)
    {
        $user = User::where('email_token', $token)->first();
        $user->verified = 1;

        if($user->save()){
            return view('email.emailconfirm', ['user' => $user]);
        }
    }
}
