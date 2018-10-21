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
    $users = DB::select("SELECT
        users.id as userid, prof_arr.profileLink, scores.score, prof_arr.location, users.firstName, users.lastName, DATE_FORMAT(users.birthday ,'%Y/%m/%d %H:%i:%s') as birthday, prof_arr.portfollio, CASE WHEN
            prof_arr.target_id IS NOT NULL THEN
            true ELSE false 
          END  as isConcern, CASE WHEN matches.status IS NOT NULL THEN matches.status ELSE 0 END as isConsult
      FROM
        users
        LEFT OUTER JOIN ( SELECT profiles.*, concern_arr.target_id
      FROM
    `profiles` LEFT OUTER JOIN ( SELECT * FROM concerns WHERE concerns.user_id = ".$user->id." ) AS concern_arr ON PROFILES.user_id = concern_arr.target_id 
        ) AS prof_arr ON users.id = prof_arr.user_id
      LEFT OUTER JOIN ( SELECT AVG( scores.score ) AS score, target_id FROM scores GROUP BY scores.target_id ) AS scores ON scores.target_id = `users`.id 
      LEFT OUTER JOIN matches ON ( matches.a_id = ".$user->id." AND matches.b_id = users.id ) OR ( matches.a_id = users.id AND matches.b_id = ".$user->id." )
      WHERE
        (users.firstName LIKE '%".$keyword."%'
        OR users.lastName LIKE '%".$keyword."%' )
      AND users.id <> ".$user->id.$where."
      ORDER BY users.id
      LIMIT ".($page-1)*$num_per_page.", ".$num_per_page);
    foreach ($users as $user) {
      if($user->isConcern == 1) {
        $user->isConcern = true;
      } else {
        $user->isConcern = false;
      }
      $user -> birthday .= "";
    }
    $response['response']['user_list'] = $users;
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

  public function removeConcern($token, $target_id){
    $input = $request->all(); 
    $user = User::where('remember_token', $input['token'])->first();
    if ($user == null) {
      # code...
      $response['message'] = "Unauthorized";
      $response['success'] = false;
      return response() -> json($response, 405);
    }
    $concern = Concern::WHERE('user_id', $user->id)->WHERE('target_id', $target_id)->first();
    $concern -> remove();
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
    $data['thread_id'] = $match -> id;
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
    $consult -> status = $input['status'];
    $consult -> save();
    $response['success'] = true;
    return response() -> json($response, 202);
  }

}