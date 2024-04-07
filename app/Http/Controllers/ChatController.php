<?php

namespace App\Http\Controllers;

use App\Events\sendmessage;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function send(Request $request){
        $user_id=$request->reciver;
        $chat=Chat::where(function($query)use($user_id){
            $query->where('f_user',Auth::user()->id)->where('l_user',$user_id);
        })->orWhere(function($query)use($user_id){
            $query->where('f_user',$user_id)->where('l_user',Auth::user()->id);
        })->first();
        if($chat){
            $message=$chat->messages()->create([
                'sender_id'=>Auth::user()->id,
                'reciver_id'=>$user_id,
                'text'=>$request->message,
                'status'=>'0'
            ]);
            broadcast(new sendmessage(User::find($user_id)->first(),$request->message));
        }else{
            $chat=Chat::create([
                'f_user'=>Auth::user()->id,
                'l_user'=>$user_id,
            ]);
            $message=$chat->messages()->create([
                'sender_id'=>Auth::user()->id,
                'reciver_id'=>$user_id,
                'text'=>$request->message,
                'status'=>'0'
            ]);
            broadcast(new sendmessage($user_id,$request->message));
        }
        return response()->json(['message'=>$request->message],200);
    }

    public function recive_message(Request $request){
        Message::where('id',$request->id)->update([
            'status'=>'1'
        ]);
        return response()->json(['message'=>'message recived'],200);
    }
    public function read_message($id){
        Message::where('id',$id)->update([
            'status'=>'2'
        ]);
        return response()->json(['message'=>'the message has been read'],200);
    }



}
