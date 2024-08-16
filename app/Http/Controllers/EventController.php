<?php

namespace App\Http\Controllers;

use App\Events\Event_Date\DeleteEventEvent;
use App\Events\Event_Date\SendEventEvent;
use App\Events\Event_Date\UpdateEventEvent;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    
        public function index(Request $request)
        {
            $events = Event::where('room_id',$request->id)->get();

            $table_name = (new Event())->getTable();

            $events->each(function($event) use ($table_name){
                $event->table_name = $table_name;
            });
            return response()->json(['events' => $events]);
        }

 
    public function sendEvent(Request $request)
    {
        $event = Event::create([
            'title' => $request->title,
            'date' => $request->date,
            'place' => $request->place,
            'maps' => $request->maps,
            'time' => $request->time,
            'agenda' => $request->agenda,
            'description' => $request->description,
            'room_id' => $request->room_id,
            'username' => $request->username,
            'user_realest_id' => $request->room_id,
        ]);
        $table_name = $event->getTable();
        $event->table_name = $table_name;
        event(new SendEventEvent($event));

        return response()->json(['event' => $event]);
    }

   
    public function updateEvent(Request $request, Event $event)
    {
        try {
            $event = Event::findOrFail($request->id);
        $event->title = $request->get('title');
        $event->date = $request->get('date');
        $event->place = $request->get('place');
        $event->maps = $request->get('maps');
        $event->time = $request->get('time');
        $event->agenda = $request->get('agenda');
        $event->description = $request->get('description');
        $event->save();
        event(new UpdateEventEvent($event));
        
        return response()->json(['event' => $event]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteEvent(Request $request)
    {
        $event = Event::findOrFail($request->id);
        $event->delete();

        event(new DeleteEventEvent($event));
        return response()->json(['event' => $event]);   
    }
}
