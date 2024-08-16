<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class UserRealest extends Model
{
    use HasFactory,HasApiTokens;

    protected $fillable = ['name','room_id'];
    protected $table = 'user_realests';
    public function message(){
        return $this->hasMany(Message::class);
    }

    public function event(){
        return $this->hasMany(Event::class);
    }
    public function reminder(){
        return $this->hasMany(Event::class);
    }

    public function room(){
        return $this->belongsToMany(Room::class,'user_room');
    }
}
