<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;


    protected $fillable = ['title','date','time','description','room_id','username','user_realest_id'];

    public function user(){
        return $this->belongsTo(UserRealest::class);
    }

    public function room(){
        return $this->belongsTo(Room::class);
    }
}
