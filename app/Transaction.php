<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [
        'user_id',
        'transaction_type',
        'transaction_amount',
        'transaction_action',
        'transaction_date',
        'user_email',
        'transaction_reference',
        'channel'
    ];

    public function users(){
        return $this->belongsTo(User::class,'user_id')->withTrashed();
    }
}
