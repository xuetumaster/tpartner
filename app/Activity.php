<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public function participants()
    {
    	return $this->hasMany(Participant::class,'activity_id');
    }
}
