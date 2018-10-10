<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function likeable()
    {
        #--- this morphTo says to Laravel this Model is part of a Polimorphyp relationship
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
