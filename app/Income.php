<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    //
    protected $fillable=[
        'income_realized',
        'income_type',
        'user_id',
        'loan_id',
 ];

    public function users(){
        return $this->belongsTo(User::class,'user_id')->withTrashed();
    }
    public function loans(){
        return $this->belongsTo(Loan::class,'loan_id');
    }

}
