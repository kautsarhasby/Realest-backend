<?php

namespace App\Http\Controllers;

use App\Events\Message\DeleteMessageEvent;
use App\Events\Message\SendMessageEvent;
use App\Events\Message\UpdateMessageEvent;
use App\Models\Message;
use App\Models\Room;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function index(Request $request){
        $messages = Message::all();
        $messages->transform(function($message){
            return [
                'id' => $message->id,
                'username' => $message->username,
                'message' => $message->message,
                'room_id' => $message->room_id,
                'edited' => $message->edited,
                'created_at' => $message->created_at->timezone('Asia/Jakarta')->format('H:i'),
            ];
        });
        $sorted =  $messages->filter(function ($message) use ($request){
            return $message['room_id'] == $request->id;
        });


        return response()->json(['message'=>$sorted->values()->all()]);
    }

    public function store(Request $request){
    
        return response()->json(['name' => $request->get('name')], 201);
    }
  

    public function sendMessage(Request $request){
        try{

            $validated = $request->validate([
                'username' => 'required|string|max:255',
                'message' => 'required|string',
                'room_id' => 'required'
            ]);
           
            $messages = new Message();
          
            $messages->username = $validated['username'];
            $messages->room_id = $validated['room_id'];
            $messages->message = $validated['message'];
            $messages->save();
           
        
            event(new SendMessageEvent(message : $messages));
    
            return response()->json([$messages],200);
        } catch(Exception $e){
            return response()->json(['error' => $e->getMessage()],400);
        }
    }

    public function updateMessage(Request $request){
        try{

            $message = Message::findOrFail($request->id);
            $message->message = $request->get('message');
            $message->edited = $request->get('edited');
            $message->save();

            event(new UpdateMessageEvent($message));

            return response()->json($message);
        } catch (Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function deleteMessage(Request $request){
        $message = Message::findOrFail($request->id);
        $message->delete();

        event(new DeleteMessageEvent($message));

        return response()->json(['message'=> $message]);   
    }
}
    