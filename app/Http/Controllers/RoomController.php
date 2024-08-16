<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\UserRealest;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $rooms = Room::all();
        return response()->json($rooms);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validate = $request->validate([
                'name_room' => 'required|string',
                'host_id' => 'required',
                'host_name' => 'required|string'
            ]);
    
            
            $room = Room::create([
                    'name_room' => $validate['name_room'],
                    'host_id' => $validate['host_id'],
                    'host_name' => $validate['host_name']
                ]);
                
            $user = UserRealest::findOrFail($request->host_id);
            

            $user->room()->attach($room->id);

            DB::commit();
            
                
            return response()->json(['room'=> $room]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'mesage' => 'Something went error' . $e->getMessage()
            ],500);
        }
      

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try{

            $room = Room::where('id',$request->id)->first();
            return response()->json([ 'room' => $room]);
        } catch (Error $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }
}
