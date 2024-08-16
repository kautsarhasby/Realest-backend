<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['username','room_id','message','edited'];

    public function user(){
        return $this->belongsTo(UserRealest::class);
    }
}
