<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanIncome extends Model
{
    //
    protected $fillable = [
        'id',
        'loan_id',
        'user_id',
        'amount',
        'value_date',
    ];


    public function loans()
    {
        return $this->belongsTo(Loan::class,'loan_id');
    }

}
