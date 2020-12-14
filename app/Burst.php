<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Burst extends Model
{
    public function user()
    {
    	return $this->belongsTo(User::class);
    }


    public function canUpdate(User $user) 
    {
        return $this->user_id == $user->id;
    }
}
