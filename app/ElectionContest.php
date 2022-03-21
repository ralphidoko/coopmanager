<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElectionContest extends Model
{
    protected $fillable=[
        'id',
        'contestant_id',
        'category_id',
        'voted_by',
        'no_of_vote',
        'remarks'
    ];

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
}
