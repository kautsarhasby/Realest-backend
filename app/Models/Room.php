<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name_room','host_id','host_name'];


    public function user(){
        return $this->belongsToMany(UserRealest::class,'user_room');
    }

    public function event(){
        return $this->hasMany(Event::class);
    }
    public function reminder(){
        return $this->hasMany(Event::class);
    }

}
