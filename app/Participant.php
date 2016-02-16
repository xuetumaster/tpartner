<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    public function activity()
    {
    	return $this->belongsTo(Activity::class);
    }
}
