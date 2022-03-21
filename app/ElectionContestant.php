<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElectionContestant extends Model
{
    protected $fillable=[
        'id',
        'user_id',
        'category_id',
        'passport'
    ];

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
}
