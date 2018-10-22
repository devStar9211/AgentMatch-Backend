<?php
namespace agent_match\Http\Controllers\API;
use Illuminate\Http\Request; 
use agent_match\Http\Controllers\Controller; 
use agent_match\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Carbon;
class UserController extends Controller 
{
public $successStatus = 200;
/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
  public function login(){ 
    if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
        $user = Auth::user(); 
        $response['response']['token'] = $user -> rollApiKey(); 
        $ret_val = $user;
        
        $gradDate = Carbon::createFromFormat('Y-m-d', $ret_val['gradDate']);
        $ret_val['gradDate'] = $gradDate -> format('Y/m');
        $birthday = Carbon::createFromFormat('Y/m', $ret_val['gradDate']);
        $ret_val['birthday'] = $birthday -> format('Y/m/d');
        $ret_val['userId'] = $ret_val['id'];
        
        $response['response']['user_info'] = $ret_val;
        $response['success']=true; 
        return response()->json($response, $this-> successStatus); 
    } 
    else{
        $response['success']=false; 
        $response['message']="登録されていないユーザーです。";
        return response()->json($response, 401); 
    } 
  }

  
/** 
   * Register api 
   * 
   * @return \Illuminate\Http\Response 
   */ 
  public function register(Request $request) 
  { 
    $validator = Validator::make($request->all(), [ 
      'email' => 'required|email',
      'password' => 'required'
    ]);
    if ($validator->fails()) { 
      return response()->json(['error'=>$validator->errors()], 401);            
    }
    $input = $request->all(); 
    $input['password'] = bcrypt($input['password']); 
    $birthday = Carbon::createFromFormat('Y/m/d', $input['birthday']);
    $input['birthday'] =  $birthday->format('Y-m-d');
    $input['gradDate'] = $input['gradDate']."/1";
    $gradDate = Carbon::createFromFormat('Y/m/d', $input['gradDate']);
    $input['gradDate']=$gradDate->format('Y-m-d');
    try{
      $user = User::create($input); 
    } catch (Exception $exception) {
      return back()->withError($exception->getMessage())->withInput();
    }
    
    $response['response']['user_id'] = $user -> id;
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
    $input['password'] = bcrypt($input['password']); 
    $birthday = Carbon::createFromFormat('Y/m/d', $input['birthday']);
    $input['birthday']=$birthday->format('Y-m-d');
    $input['gradDate'] = $input['gradDate']."/1";
    $gradDate = Carbon::createFromFormat('Y/m/d', $input['gradDate']);
    $input['gradDate']=$gradDate->format('Y-m-d');
    
    try{
      $user = User::find($input['id']); 
      $user->update($input);
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
}