<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    //
    protected $fillable = [
        'user_id',
        'action_performed',
        'method',
        'user_agent',
        'ip_address',
        'url'
    ];

    public function users(){
        return $this->belongsTo(User::class,'user_id')->withTrashed();
    }
}
