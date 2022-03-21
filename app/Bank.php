<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    //
    protected $fillable =[
        'id',
        'bank_name',
        'account_no',
        'user_id',
        'account_name'
    ];


    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
