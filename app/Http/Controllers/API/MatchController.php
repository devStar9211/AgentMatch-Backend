<?php
namespace agent_match\Http\Controllers\API;
use Illuminate\Http\Request; 
use agent_match\Http\Controllers\Controller; 
use agent_match\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Carbon;
use agent_match\Profile;
use DB;
use agent_match\Score;
use agent_match\Match;
use agent_match\Concern;
use Storage;
class MatchController extends Controller 
{
public $successStatus = 200;
/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
  public function getList($token, Request $request){ 
    $input = $request -> all();
    if (array_key_exists("page", $input)) $page = $input['page'];
    else $page = 1;
    
    if (array_key_exists("keyword", $input)) $keyword = $input['keyword'];
    else $keyword = "";
    $where = "";
    if (array_key_exists("concern", $input)) $where = " AND prof_arr.target_id IS NOT NULL";
    $user = User::where('remember_token', $token)->first();
    if ($user == null) {
      # code...
      $response['message'] = "Unauthorized";
      $response['success'] = false;
      return response() -> json($response, 405);
    }
    
    $num_per_page = 10;
    $users = User::where('id', '<>', $user->id)->skip(($page-1)*$num_per_page) -> take($num_per_page) -> get();

    if (sizeof($users) != 0) {
      # code...
      
      foreach ($users as $cur_user) {
        if ($cur_user -> id != $user -> id) {
          # code...
          $user_info['userId'] = $cur_user -> id;
          $profile = $user -> profile() -> first();
          $user_info['profileLink'] = $profile  -> profileLink;
          $score = Score::where('target_id', $cur_user -> id) -> get();
          if (!is_null($score)) {
            # code...
            $user_info['score'] = $score  -> avg('score');
          } else {
            $user_info['score'] = null;
          }
          
          $user_info['location'] = $profile -> location;
          $user_info['firstName'] = $cur_user -> firstName;
          $user_info['lastName'] = $cur_user -> lastName;
          $user_info['birthday'] = $cur_user -> birthday;
          $user_info['portfollio'] = $profile -> portfollio;
          $concern = Concern::where('user_id', $user -> id) -> where('target_id', $cur_user -> id) -> get();
          if (sizeof($concern) != 0) {
            $user_info['isConcern'] = true;
          } else {
            $user_info['isConcern'] = false;
          }

          $match = Match::where(function($query) use($cur_user, $user) {
            return $query -> where('a_id', $user -> id) -> where('b_id', $cur_user -> id);
          }) -> orWhere(function($query) use ($user, $cur_user) {
            return $query -> where('a_id', $cur_user->id) -> where('b_id', $user -> id);
          }) -> latest() -> first();

          if (!is_null($match)) {
            # code...
            $user_info['isConsult'] = $match -> status;
          } else {
            $user_info['isConsult'] = 0;
          }
          $user_info['signalId'] = $cur_user -> signalId;
          $user_list[] = $user_info;
        }
        
      }
    } else {
      $user_list = array();
    }
    $response['response']['user_list'] = $user_list;
    $response['success'] = true;
    return response() -> json($response, 202);
  }

  public function setScore(Request $request){
    $input = $request->all(); 
    $score = new Score;
    $token = $input['token'];
    $user = User::where('remember_token', $token)->first();
    if ($user == null) {
      # code...
      $response['message'] = "Unauthorized";
      $response['success'] = false;
      return response() -> json($response, 405);
    }
    $score -> user_id = $user -> id;
    $score -> target_id = $input['to'];
    $score -> score = $input['score'];
    $score -> save();
    $response['success'] = true;
    return response() -> json($response, 202);
  }

  public function setConcern(Request $request){
    $input = $request->all(); 
    $concern = new Concern;
    $user = User::where('remember_token', $input['token'])->first();
    if ($user == null) {
      # code...
      $response['message'] = "Unauthorized";
      $response['success'] = false;
      return response() -> json($response, 405);
    }
    $concern -> user_id = $user -> id;
    $concern -> target_id = $input['to'];
    $concern -> save();
    $response['success'] = true;
    return response() -> json($response, 202);
  }

  public function removeConcern(Request $request){
    $input = $request->all(); 
    $user = User::where('remember_token', $input['token'])->first();
    if ($user == null) {
      # code...
      $response['message'] = "Unauthorized";
      $response['success'] = false;
      return response() -> json($response, 405);
    }
    $target_id = $input['to'];
    $concern = DB::table('concerns')->where('user_id', $user->id)->WHERE('target_id', $target_id)->delete();
    $response['success'] = true;
    return response() -> json($response, 202);
  }

  public function setConsult(Request $request){
    $input = $request->all(); 
    $user = User::where('remember_token', $input['token'])->first();
    if ($user == null) {
      # code...
      $response['message'] = "Unauthorized";
      $response['success'] = false;
      return response() -> json($response, 405);
    }
    $match = DB::select("SELECT matches.status FROM matches WHERE ( matches.a_id = ".$input['from']." AND matches.b_id = ".$input['to']." ) OR ( matches.a_id = ".$input['to']." AND matches.b_id = ".$input['from'] );
    if ($match != null) {
      # code...
      $match->status = $input['status'];
    }
    else {
      $match = new Match;
      $match -> a_id = $input['from'];
      $match -> b_id = $input['to'];
      $match -> status = $input['status'];

    }
    $match -> save();
    $response['success'] = true;
    return response() -> json($response, 202);
  } 

  public function request_consult(Request $request) {
    $input = $request->all(); 
    $user = User::where('remember_token', $input['token'])->first();
    if ($user == null) {
      # code...
      $response['message'] = "Unauthorized";
      $response['success'] = false;
      return response() -> json($response, 405);
    }
    $match = new Match;
    $match -> a_id = $user -> id;
    $match -> b_id = $input['to'];
    $match -> status = 1;
    $match -> save();
    $response['success'] = true;
    $data['consultId'] = $match -> id;
    $data['status'] = 1;

    $response['response'] = $data;
    return response() -> json($response, 202);
  }

  public function accept_consult(Request $request) {
    $input = $request->all(); 
    $user = User::where('remember_token', $input['token'])->first();
    if ($user == null) {
      # code...
      $response['message'] = "Unauthorized";
      $response['success'] = false;
      return response() -> json($response, 405);
    }
    $consult = Match::find($input['consultId']);
    $consult -> status = 2;
    $consult -> save();
    $response['success'] = true;
    return response() -> json($response, 202);
  }

  public function reject_consult(Request $request) {
    $input = $request->all(); 
    $user = User::where('remember_token', $input['token'])->first();
    if ($user == null) {
      # code...
      $response['message'] = "Unauthorized";
      $response['success'] = false;
      return response() -> json($response, 405);
    }
    $consult = Match::find($input['consultId']);
    $consult -> status = 0;
    $consult -> save();
    $response['success'] = true;
    return response() -> json($response, 202);
  }

   public function update_signal_id(Request $request){
    $input = $request->all(); 
    $concern = new Concern;
    $user = User::where('remember_token', $input['token'])->first();
    if ($user == null) {
      # code...
      $response['message'] = "Unauthorized";
      $response['success'] = false;
      return response() -> json($response, 405);
    }
    $signal_id = $input['signalId'];
    $user -> signalId = $signal_id;
    $user -> save();
    $response['success'] = true;
    return response() -> json($response, 202);
  }

  public function upload(Request $request)
    {
      $file = $request->file('image');
      $filename = substr( md5( time() ), 0, 15) . '.jpg';

      Storage::put($filename,file_get_contents($file));
      $path = Storage::url('app/'.$filename);
      $response['success'] = true;
      $response['response']['imageLink'] = $path;
      return response() -> json($response, 202);
      
    }

}