<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dividend extends Model
{
    //
    protected $fillable = [
        'id',
        'user_id',
        'loan_patronage_dividend',
        'dividend',
        'total_dividends',
        'financial_year'
    ];

    public function users(){
        return $this->belongsTo(User::class,'user_id')->withTrashed();
    }
}
