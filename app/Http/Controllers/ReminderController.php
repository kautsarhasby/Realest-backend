<?php

namespace App\Http\Controllers;

use App\Events\Reminder\DeleteReminderEvent;
use App\Events\Reminder\SendReminderEvent;
use App\Events\Reminder\UpdateReminderEvent;
use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
   
    public function index(Request $request)
    {
        $reminders = Reminder::where('room_id',$request->id)->get();
        $table_name = (new Reminder())->getTable();

        $reminders->each(function ($reminder) use ($table_name){

            $reminder->table_name = $table_name;
        });
        return response()->json(['reminders' => $reminders]);
    }


 
    public function create()
    {
        //
    }

    public function sendReminder(Request $request)
    {
        $reminder = Reminder::create([
            'title' => $request->title,
            'date' => $request->date,
            'time' => $request->time,
            'description' => $request->description,
            'room_id' => $request->room_id,
            'username' => $request->username,
            'user_realest_id' => $request->room_id,
        ]);
        $table_name = $reminder->getTable();
        $reminder->table_name = $table_name;

        event(new SendReminderEvent(reminder : $reminder));

        return response()->json($reminder);
    }

  
    public function updateReminder(Request $request)
    {
        try {
            $reminder = Reminder::findOrFail($request->id);
        $reminder->title = $request->get('title');
        $reminder->date = $request->get('date');
        $reminder->time = $request->get('time');
        $reminder->description = $request->get('description');
        $reminder->save();
        event(new UpdateReminderEvent($reminder));
        
        return response()->json(['reminder' => $reminder]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function deleteReminder(Request $request)
    {
        $reminder= Reminder::findOrFail($request->id);
        $reminder->delete();

        event(new DeleteReminderEvent($reminder));

        return response()->json(['reminder'=>$reminder]);
    }
}
