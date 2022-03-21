<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthorityToDeductPay extends Model
{
    //

    protected $fillable = [
        'user_id',
        'authorized_amount',
        'start_date',
        'inc_dec_amount',
        'status',
        'certification',
        'ippis_no'
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id')->withTrashed();
    }


}
