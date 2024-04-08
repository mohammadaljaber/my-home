<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use App\Models\Message;
use App\Events\sendmessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function send(Request $request) {
        $rules = [
            'message' => 'required|string',
            'receiver' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) return response()->json($validator->errors(), 403);
        $user = auth()->user();
        $receiver = User::find($request->receiver);
        $chat = Chat::where(function($query) use ($user, $receiver) {
            $query->where('f_user',$user->id)->where('s_user',$receiver->id);
        })->orWhere(function($query) use ($user, $receiver) {
            $query->where('f_user',$receiver->id)->where('s_user',$user->id);
        })->first();
        if(!$chat) {
            $chat=Chat::create([
                'f_user' => $user->id,
                's_user' => $receiver->id,
            ]);
        }
        $chat->messages()->create([
            'sender_id' => $user->id,
            'receiver_id' => $receiver->id,
            'text' => $request->message,
            'status' => '0',
        ]);
        broadcast(new sendmessage($receiver,$request->message));
        return response()->json(['message'=>$request->message],200);
    }

    public function receive_message(Request $request) {
        Message::where('id',$request->id)->update([
            'status' => '1',
        ]);
        return response()->json(['message' => 'message received'],200);
    }

    public function read_message($id) {
        Message::where('id',$id)->update([
            'status' => '2',
        ]);
        return response()->json(['message' => 'the message has been read'],200);
    }

}
