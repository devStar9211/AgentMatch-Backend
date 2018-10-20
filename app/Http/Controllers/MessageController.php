<?php

namespace agent_match\Http\Controllers;

use Illuminate\Http\Request;
use agent_match\User;
use agent_match\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Carbon;
use Profile;
use DB;
use agent_match\Score;
use agent_match\Match;
use agent_match\Concern;
use Debugbar;
use agent_match\Message;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  // public function index($token, Request $request) {
  //   $input = $request -> all();
  //   if (array_key_exists("page", $input)) $page = $input['page'];
  //   else $page = 1;
    
  //   if (array_key_exists("keyword", $input)) $keyword = $input['keyword'];
  //   $keyword = "";

  //   $user = User::where('remember_token', $token)->first();
  //   if ($user == null) {
  //     # code...
  //     $response['message'] = "Unauthorized";
  //     $response['success'] = false;
  //     return response() -> json($response, 405);
  //   }
    
  //   $num_per_page = 10;
  //   $result = DB::select("SELECT
  //       receiver_id,
  //       sender_id 
  //     FROM
  //       messages 
  //     WHERE
  //       sender_id = ".$user -> id." UNION
  //     SELECT
  //       f.receiver_id,
  //       f.sender_id 
  //     FROM
  //       ( SELECT receiver_id AS sender_id, sender_id AS receiver_id FROM messages WHERE receiver_id = ".$user -> id." ) as f");
  //   $person_list = [];
  //   foreach ($result as $key => $each) {
  //     # code...
  //     // $person = json_encode("{}", true);
  //     $person['id'] = $each->receiver_id;
  //     $res_user = User::where('id', $each->receiver_id)->first();
  //     if ($res_user) {
  //       # code...
  //       $person['name'] = $res_user -> firstName." ".$res_user -> lastName;
  //     } else {
  //       $person['name'] = "";
  //     }
      
  //     $messages = Message::where(function($query) use ($user, $person) {
  //       $query -> where('sender_id', $user -> id) -> where('receiver_id', $person['id']);
  //     })->orWhere(function($query) use ($user, $person) {
  //       $query -> where('receiver_id', $user -> id) -> where('sender_id', $person['id']);
  //     });

  //     $match = new Match;
  //     $status = $match->getStatus($user -> id, $each->receiver_id) -> get();
  //     $person['status'] = $status->first()['status'];
  //     $person['messages'] = $messages -> get() ->toArray();
  //     $person_list[] = $person;
  //     $person = [];
  //   }
  //   $response['response']['user_list'] = $person_list;
  //   $response['success'] = true;
  //   return response() -> json($response, 202);
  // }

  public function index(Request $request){
    $input = $request -> all();
    $user = User::where('remember_token', $input['token'])->first();
    $type = $input['type'];
    if ($user == null) {
      # code...
      $response['message'] = "Unauthorized";
      $response['success'] = false;
      return response() -> json($response, 405);
    }
    if ($type == 'true') {
      # code...
      $matches = Match::where('a_id', $user -> id)->get();
    }
    else {
      $matches = Match::where('b_id', $user -> id)->get(); 
    }
    foreach ($matches as $index => $match) {
      # code...
      if ($type == 'true') {
        $target = User::find($match->b_id);
      }
      else {
        $target = User::find($match->a_id);
      }
      
      $profile = $target -> profile() -> first();

      $userinfo['userid'] = $target -> id;
      $userinfo['firstName'] = $target -> firstName;
      $userinfo['lastName'] = $target -> lastName;
      $userinfo['profileLink'] = $profile -> profileLink;
      $consult['userinfo'] = $userinfo;
      $consult['consultId'] = $match -> id;
      $consult['threadId'] = $match -> id;
      $consult['createdAt'] = $match -> created_at -> format('Y/m/d');
      
      $consult['status'] = $match -> status;


      $consults[] = $consult;
    }
    $consult_list['consult_list'] = $consults;
    $response['response'] = $consult_list;
    $response['success'] = true;

    return response() -> json($response, 202);
    
  }

  public function send(Request $request) {
    $input = $request->all(); 
    $user = User::where('remember_token', $input['token'])->first();
    if ($user == null) {
      # code...
      $response['message'] = "Unauthorized";
      $response['success'] = false;
      return response() -> json($response, 405);
    }
    $match = Match::find($input['threadId']);
    if ($user -> id == $match -> a_id) {
      $target = $match -> b_id;
    } else {
      $target = $match -> a_id;
    }

    $message = new Message;
    $message->sender_id = $user->id;
    $message->receiver_id = $target;
    $message->contents = $input['message'];
    $message->save();
    $response['success'] = true;
    return response() -> json($response, 202);
  }

  public function get_concern_list(Request $request) {
    $input = $request->all(); 
    $user = User::where('remember_token', $input['token'])->first();
    if ($user == null) {
      # code...
      $response['message'] = "Unauthorized";
      $response['success'] = false;
      return response() -> json($response, 405);
    }
    $targets = Concern::where('user_id', $user -> id) -> get();
    foreach ($targets as $index => $target) {
      $user_info = User::find($target -> target_id);
      $score = Score::where('target_id', $target -> target_id)->avg('score');
      $userinfo['userid'] = $user_info -> id;
      $userinfo['firstName'] = $user_info -> firstName;
      $userinfo['lastName'] = $user_info -> lastName;
      $userinfo['birthday'] = Carbon::parse($user_info -> birthday) -> format('Y/m/d');
      $userinfo['score'] = $score;
      $userinfo['createdAt'] = $user_info -> created_at -> format('Y/m/d');
      $concerns[] = $userinfo;
    }
    $concern_list['concern_list'] = $concerns;
    $response['response'] = $concern_list;
    $response['success'] = true;
    return response() -> json($response, 202);
  }

  public function get_message(Request $request) {
    $input = $request -> all();
    $user = User::where('remember_token', $input['token'])->first();
    if ($user == null) {
      $response['message'] = "Unauthorized";
      $response['success'] = false;
      return response() -> json($response, 405);
    }
    $threadId = $input['threadId'];
    $match = Match::find($threadId);
    $messages = Message::where('match_id', $threadId) -> get();
    foreach ($messages as $index => $message) {
      $senderInfo['userId'] = $message -> sender_id;
      $sender = User::find($message -> sender_id);
      $senderInfo['firstName'] = $sender -> firstName;
      $senderInfo['lastName'] = $sender -> lastName;
      $senderInfo['profileLink'] = $sender -> profile() -> first() -> profileLink;
      $message_info = $message -> contents;
      $image_link = $message -> image_link;
      $createdAt = $message -> created_at -> format('Y/m/d');
      $message_row['senderInfo'] = $senderInfo;
      $message_row['message'] = $message_info;
      $message_row['imageLink'] = $image_link;
      $message_row['createdAt'] = $createdAt;
      $message_list[] = $message_row;
    }
    $response['success'] = true;
    // $response['messages'] = $messages;
    $response['response']['message_list'] = $message_list;
    return response() -> json($response, 202);

  }

  public function get_last_message(Request $request) {
    $input = $request -> all();
    $user = User::where('remember_token', $input['token'])->first();
    if ($user == null) {
      $response['message'] = "Unauthorized";
      $response['success'] = false;
      return response() -> json($response, 405);
    }
    $threadId = $input['threadId'];
    $match = Match::find($threadId);
    $message = Message::where('match_id', $threadId) -> latest() -> first();
    $sender = User::find($message -> sender_id);
    $senderInfo['userId'] = $sender -> id;
    $senderInfo['firstName'] = $sender -> firstName;
    $senderInfo['lastName'] = $sender -> lastName;
    $senderInfo['profileLink'] = $sender -> profile() -> first() -> profileLink;
    $message_info = $message -> contents;
    $image_link = $message -> image_link;
    $createdAt = $message -> created_at -> format('Y/m/d');
    $message_row['senderInfo'] = $senderInfo;
    $message_row['message'] = $message_info;
    $message_row['imageLink'] = $image_link;
    $message_row['createdAt'] = $createdAt;
    $response['message'] = $message_row;
    $response['success'] = true;
    return response() -> json($response);
  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
