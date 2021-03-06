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
use agent_match\Thank;
use agent_match\Event;
use agent_match\EventJoinList;
use Storage;
class MatchController extends Controller 
{
public $successStatus = 200;
/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
  public function getList(String $token, Request $request) { 
    $input = $request;// -> toArray();

    if (array_key_exists("page", $input)) {
      $page = $input['page'];
    } else {
      $page = 1;
    }
    
    if (array_key_exists("keyword", $input) ) {
      $keyword = $input['keyword'];
    } else {
      $keyword = "";
    }

    if (array_key_exists("concern", $input)) {
      $where = " AND prof_arr.target_id IS NOT NULL";
    }
    $user = User::where('remember_token', $token)->first();

    if ($user == null) {
      # code...
      $response['message'] = "Unauthorized";
      $response['success'] = false;
      return response() -> json($response, 405);
    }
    $query = User::where('id', '<>', $user->id);
    $num_per_page = 10;
    if ($user -> userType == 1) {
      $query = $query -> where('userType',0);
    } elseif ($user -> userType ==0) {
      $query = $query -> where('userType',1);
    }
    $users = $query->where(DB::raw("CONCAT(firstName,lastName)"), "LIKE", "%".$keyword."%")->skip(($page-1)*$num_per_page) -> take($num_per_page) -> get();
   
    $user_list = array();
    if (sizeof($users) != 0) {
      # code...
      
      foreach ($users as $cur_user) {
        if ($cur_user -> id != $user -> id) {
          # code...
          $user_info['userId'] = $cur_user -> id;
          $profile = $cur_user -> profile() -> first();
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
          $user_info['userType'] = $cur_user -> userType;
          $birthday = Carbon::createFromFormat('Y-m-d', $cur_user -> birthday);

          $user_info['birthday'] = $birthday -> format('Y/m/d');
          $thanks = new Thank();
          $user_info['thanksCount'] = $thanks -> thanks_count($cur_user -> id);
          if (!is_null($cur_user -> gradDate)) {
            # code...
            $gradDate = Carbon::createFromFormat('Y-m-d', $cur_user -> gradDate);
            $user_info['gradDate'] = $gradDate -> format('Y/m');
          } else {
            $user_info['gradDate'] = "";
          }
          
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

          $matches = new Match();
          $match_count = $matches->match_counts($cur_user->id);
          $user_info['consultCount'] = $match_count;
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
    if (!is_null($input['token'])) {
      # code...
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
    else {
      $response['success'] = false;
      return response() -> json($response, 405);
    }
    
   
    
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

    public function set_thanks(Request $request) {
      $input = $request -> all();
      if (!is_null($input['token'])) {
        # code...
        $user = User::where('remember_token', $input['token'])->first();
         if ($user == null) {
        # code...
          $response['message'] = "Unauthorized";
          $response['success'] = false;
          return response() -> json($response, 405);
        }
        $thank = new Thank();
        $thank -> user_id = $user -> id;
        if (array_key_exists('to', $input)) {
          # code...
          $thank -> target_id = $input['to'];
        }
        if (array_key_exists('comment', $input)) {
          # code...
          $thank -> comment = $input['comment'];
        }
        $thank -> save();
        $response['success'] = true;
        return response() -> json($response, 202);
      }
      else {
        $response['success'] = false;
        return response() -> json($response, 406);
      }
    }

    public function get_thanks_list($id){
      $user = User::find($id)->first();
       if ($user == null) {
      # code...
        $response['message'] = "Unauthorized";
        $response['success'] = false;
        return response() -> json($response, 405);
      }

      $thank = new Thank();
      $thanks_senders = $thank -> thanks_senders($id);
      $thank_infos = array();
      foreach ($thanks_senders as $thank_data) {
        $thank_info['comment'] = $thank_data -> comment;
        $thank_info['createdAt'] = $thank_data -> created_at -> format('Y/m/d H:i:s');

        $sender = User::find($thank_data -> user_id) -> first();
        $thank_info['user_info']['userId'] = $sender -> id;
        $thank_info['user_info']['firstName'] = $sender -> firstName;
        $thank_info['user_info']['lastName'] = $sender -> lastName;
        $thank_infos[] = $thank_info;
      }
      $response['response']['thank_info'] = $thank_infos;
      $response['success'] = true;
      return response() -> json($response, 202);
    }

    function php_version(){
      return response() -> json(phpinfo(), 202);
    }


    // event

    function get_event_list($token){
      if (!is_null($token)) {
        # code...
        $user = User::where('remember_token', $token)->first();
         if ($user == null) {
        # code...
          $response['message'] = "Unauthorized";
          $response['success'] = false;
          return response() -> json($response, 405);
        }
        $events = Event::all();
        foreach ($events as $event) {
          $event_item['eventId'] = $event -> id;
          $event_item['title'] = $event -> title;
          $event_item['date'] = $event -> date;
          $event_times = $event -> event_times() ->get();
          $joined = false;
          $event_item['timeId'] = null;
          $times = [];
          foreach ($event_times as $event_time) {
            $time = Carbon::createFromFormat('Y-m-d H:i:s', $event_time -> time);
            $times[] = $time -> format('H:i:s');
            
          }
          $joined_user = $event -> event_join_users() -> where('user_id', $user -> id) -> first();
          if (!is_null($joined_user)) {
             $joined = true;
             $event_item['timeId'] = $joined_user -> event_time_id;
           } 
          $event_item['isJoined'] = $joined;
          $event_item['startTime'] = $times;
          $event_list[] = $event_item;
        }
        $response['response']['eventList'] = $event_list;
        $response['success'] = true;
      }
      return response() -> json($response, 201);
    }


    function join_event(Request $request) {
      $input = $request -> all();
      if (!is_null($input['token'])) {
        # code...
        $user = User::where('remember_token', $input['token'])->first();
         if ($user == null) {
        # code...
          $response['message'] = "Unauthorized";
          $response['success'] = false;
          return response() -> json($response, 405);
        }

      }

      $event_id = $request['eventId'];
      $join_user = new EventJoinList();
      $join_user -> user_id = $user -> id;
      $join_user -> event_id = $event_id;
      $join_user -> save();
      $response['success'] = true;
      $response['response']=[];
      return response() -> json($response, 201);
    }

    function start_time_event(Request $request) {
      $input = $request -> all();
      if (!is_null($input['token'])) {
        # code...
        $user = User::where('remember_token', $input['token'])->first();
         if ($user == null) {
        # code...
          $response['message'] = "Unauthorized";
          $response['success'] = false;
          return response() -> json($response, 405);
        }
      }

      $event_id = $request['eventId'];
      $time_id = $request['timeId'];
      $join_user = EventJoinList::find($event_id);
      $join_user -> user_id = $user -> id;
      $join_user -> event_time_id = $time_id;
      $join_user -> save();
      $response['success'] = true;
      $response['response']=[];
      return response() -> json($response, 201);
    }




}