<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Installment extends Model
{
    //

    use Notifiable;

    //creating uuid for installment model
    /**
     * @var mixed
     */

    public $incrementing = true;
//
//    protected static function boot()
//    {
//        parent::boot();
//        static::creating(function($model){
//            $model->id = Str::uuid();
//        });
//    }

    protected $fillable = [
        'loan_id',
        'unique_id',
        'monthly_installment',
        'payment_date',
        'status',
        'current_balance',
        'extral_id'
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class,'loan_id');
    }
}
