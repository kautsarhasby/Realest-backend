<?php

namespace App\Http\Controllers;

use App\Events\Information\DeleteInformationEvent;
use App\Events\Information\SendInformationEvent;
use App\Events\Information\UpdateInformationEvent;
use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
  
    public function index(Request $request)
    {
        $informations = Information::all();
        $informations->transform(function($information){
            return [
                'id' => $information->id,
                'title' => $information->title,
                'link' => $information->link,
                'description' => $information->description,
                'author' => $information->author,
                'author_id' => $information->author_id,
                'room_id' => $information->room_id,
                'created_at' => $information->created_at->diffForHumans()
            ];
        });
        $sorted =  $informations->filter(function ($information) use ($request){
            return $information['room_id'] == $request->id;
        });


        return response()->json(['informations'=>$sorted->values()->all()]);
        

    }

  
    public function sendInformation(Request $request)
    {
        $information = Information::create([
            'title' => $request->title,
            'link' => $request->link,
            'description' => $request->description,
            'room_id' => $request->room_id,
            'author' => $request->author,
            'author_id' => $request->author_id,
        ]);

        event(new SendInformationEvent($information));

        return response()->json(['information'=> $information]);
    }

 
    public function updateInformation(Request $request, Information $information)
    {
        try {
            $information = Information::findOrFail($request->id);

        $information->title = $request->get('title');
        $information->link = $request->get('link');
        $information->description = $request->get('description');
        $information->save();
        event(new UpdateInformationEvent($information));

        return response()->json(['information' => $information]);
        } catch (\Exception $e) {
            return response()->json(['error'=> $e->getMessage()]);
        }
    }

   
    public function deleteInformation(Request $request)
    {
        $information = Information::findOrFail($request->id);
        $information->delete();

        event(new DeleteInformationEvent($information));

        return response()->json(['information'=>$information]);
    }
}
