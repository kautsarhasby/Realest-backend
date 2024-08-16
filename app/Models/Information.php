<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $fillable = ['title','link','description','room_id','author','author_id'];
    protected $table = 'informations';
    public function user(){
        return $this->belongsTo(UserRealest::class);
    }

    public function room(){
        return $this->belongsTo(Room::class);
    }
}

