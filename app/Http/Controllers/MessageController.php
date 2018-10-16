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
use Score;
use Match;
use Concern;
use Debugbar;
use agent_match\Message;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index($token, Request $request) {
    $input = $request -> all();
    if (array_key_exists("page", $input)) $page = $input['page'];
    else $page = 1;
    
    if (array_key_exists("keyword", $input)) $keyword = $input['keyword'];
    $keyword = "";

    $user = User::where('remember_token', $token)->first();
    if ($user == null) {
      # code...
      $response['message'] = "Unauthorized";
      $response['success'] = false;
      return response() -> json($response, 405);
    }
    
    $num_per_page = 10;
    $result = DB::select("SELECT
        receiver_id,
        sender_id 
      FROM
        messages 
      WHERE
        sender_id = ".$user -> id." UNION
      SELECT
        f.receiver_id,
        f.sender_id 
      FROM
        ( SELECT receiver_id AS sender_id, sender_id AS receiver_id FROM messages WHERE receiver_id = ".$user -> id." ) as f");
    $person_list = [];
    foreach ($result as $key => $each) {
      # code...
      // $person = json_encode("{}", true);
      $person['id'] = $each->receiver_id;
      $res_user = User::where('id', $each->receiver_id)->first();
      if ($res_user) {
        # code...
        $person['name'] = $res_user -> firstName." ".$res_user -> lastName;
      } else {
        $person['name'] = "";
      }
      
      $messages = Message::where(function($query) use ($user, $person) {
        $query -> where('sender_id', $user -> id) -> where('receiver_id', $person['id']);
      })->orWhere(function($query) use ($user, $person) {
        $query -> where('receiver_id', $user -> id) -> where('sender_id', $person['id']);
      });
      $person['messages'] = $messages -> get() ->toArray();
      $person_list[] = $person;
      $person = [];
    }
    $response['response']['user_list'] = $person_list;
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
    $message = new Message;
    $message->sender_id=$user->id;
    $message->receiver_id = $input['receiver_id'];
    $message->contents = $input['contents'];
    $message->status = 1;
    $message->save();
    $response['success'] = true;
    return response() -> json($response, 202);
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
