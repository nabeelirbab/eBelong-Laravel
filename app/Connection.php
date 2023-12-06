<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    protected $fillable = [
        'user_id',
        'connected_user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function connected()
    {
        return $this->belongsTo('App\User', 'connected_user_id', 'id');
    }
}
