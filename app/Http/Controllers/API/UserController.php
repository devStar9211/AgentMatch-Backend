<?php
namespace agent_match\Http\Controllers\API;
use Illuminate\Http\Request; 
use agent_match\Http\Controllers\Controller; 
use agent_match\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Carbon;
use agent_match\Profile;
class UserController extends Controller 
{
public $successStatus = 200;
/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
  public function login(){ 
    if (request('authToken')) {
      # code...
      $user = User::where('email', request('email')) -> where('authToken', request('authToken')) -> first();

      if(is_null($user)){ 
        $response['success']=false; 
        $response['message']="登録されていないユーザーです。";
        return response()->json($response, 401); 
      } 
    }
    elseif(request('password')) {
      # code...
      if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
          $user = Auth::user(); 
          
      } 
      else{
        $response['success']=false; 
        $response['message']="登録されていないユーザーです。";
        return response()->json($response, 401); 
      } 
    }

    $response['response']['token'] = $user -> rollApiKey(); 
    $ret_val = $user;
    if (!is_null($ret_val['gradDate'])) {
      # code...
      $gradDate = Carbon::createFromFormat('Y-m-d', $ret_val['gradDate']);
      $ret_val['gradDate'] = $gradDate -> format('Y/m');
    }
    else {
      $ret_val['gradDate'] = "";
    }
    
    $birthday = Carbon::createFromFormat('Y-m-d', $ret_val['birthday']);
    $ret_val['birthday'] = $birthday -> format('Y/m/d');
    $ret_val['userId'] = $ret_val['id'];
    $prof = $user -> profile();
    if (array_key_exists('profileLink', $prof)) {
      # code...
      $ret_val['profileLink'] = $prof -> profileLink;
    } else {
      $ret_val['profileLink'] = "";
    }
    
    $response['response']['user_info'] = $ret_val;
    $response['success']=true; 
    return response()->json($response, $this-> successStatus); 
    
    
  }

  
/** 
   * Register api 
   * 
   * @return \Illuminate\Http\Response 
   */ 
  public function register(Request $request) 
  { 
    $validator = Validator::make($request->all(), [ 
      'email' => 'required|email'
    ]);
    if ($validator->fails()) { 
      return response()->json(['error'=>$validator->errors()], 401);
    }
    $input = $request->all(); 
    if (array_key_exists('password', $input)) {
      # code...
      $input['password'] = bcrypt($input['password']); 

    }
    
    $birthday = Carbon::createFromFormat('Y/m/d', $input['birthday']);
    $input['birthday'] =  $birthday->format('Y-m-d');
    if ($input['gradDate']!='') {
      # code...
      $input['gradDate'] = $input['gradDate']."/1";
      $gradDate = Carbon::createFromFormat('Y/m/d', $input['gradDate']);
      $input['gradDate']=$gradDate->format('Y-m-d');
    }
    
    try{
      $user = User::create($input); 
      $user -> authToken = $input['authToken'];
      $user -> update();
      $pro_data['user_id'] = $user -> id;
      $pro_data['profileLink'] = $input['profileLink'];
      $profile = profile::create($pro_data);
    } catch (Exception $exception) {
      return back()->withError($exception->getMessage())->withInput();
    }
    
    $response['response']['user_id'] = $user -> id;
    $response['response']['token'] = $user -> rollApiKey(); 
    
    $response['success'] = true;
    $success['firstName'] =  $user->firstName;
    return response()->json($response, 202); 
  }

  public function edit($user_id){
    $user = User::find($user_id);
    return response()->json([$user], $this->successStatus);
  }

  public function update(Request $request)
  {
    $validator = Validator::make($request->all(), [ 
      'email' => 'required|email',
      'password' => 'required'
    ]);
    if ($validator->fails()) { 
      return response()->json(['error'=>$validator->errors()], 401);            
    }
    $input = $request->all(); 
    if ($input['password']!='' || array_key_exists('password', $input)) {
      # code...
      $input['password'] = bcrypt($input['password']); 
    }
    
    $birthday = Carbon::createFromFormat('Y/m/d', $input['birthday']);
    $input['birthday']=$birthday->format('Y-m-d');
    if ($input['gradDate']!='') {
      # code...
      $input['gradDate'] = $input['gradDate']."/1";
      $gradDate = Carbon::createFromFormat('Y/m/d', $input['gradDate']);
      $input['gradDate']=$gradDate->format('Y-m-d');
    }
    
    
    try{
      $user = User::find($input['id']); 
      $user->update($input);
      $prof = $user -> profile();
      if ($prof) {
        # code...
        $prof -> profileLink = $input['profileLink'];
        $prof -> update();
      }
    } catch (Exception $exception){
      return response()->json(['error'=>$exception->messages()], 401);  
    }

    $response['response']['user_id'] = $user -> id;
    $response['success'] = true;
    $success['firstName'] =  $user->firstName;
    return response()->json($response, 202); 
  }
/** 
   * details api 
   * 
   * @return \Illuminate\Http\Response 
   */ 
  public function details() 
  { 
      $user = Auth::user(); 
      return response()->json(['success' => $user], $this-> successStatus); 
  } 

  public function get_user_with_face(Request $request){ 
    $input = $request->all();
        $user = User::where('authToken', $input['authToken'])->first(); 
        // $response['response']['token'] = $user -> rollApiKey(); 
        if ($user) {
          # code...
          $ret_val = $user;
        
          $gradDate = Carbon::createFromFormat('Y-m-d', $ret_val['gradDate']);
          $ret_val['gradDate'] = $gradDate -> format('Y/m');
          $birthday = Carbon::createFromFormat('Y/m', $ret_val['gradDate']);
          $ret_val['birthday'] = $birthday -> format('Y/m/d');
          $prof = $user -> profile();
          $ret_val['profileLink'] = $prof -> profileLink;
          $ret_val['userId'] = $ret_val['id'];
          $response['token'] = $user -> remember_token;
          $response['response']['user_info'] = $ret_val;

        }
        else {
          $response['token'] = null;
          $response['response']['user_info'] = null;
        }
        
        
        $response['success']=true; 
        return response()->json($response, $this-> successStatus); 
    } 
}