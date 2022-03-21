<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Loan extends Model
{
    //

    use Notifiable;

    //creating uuid for user model
    /**
     * @var mixed
     */

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function($model){
            $model->id = Str::uuid();
        });
    }
    protected $fillable = [
        'loan_amount',
        'total_amount_payable',
        'total_interest_payable',
        'loan_type',
        'monthly_interest_payable',
        'cash_loan_rate',
        'no_of_installments',
        'amount_recovered',
        'item_loan_tenor',
        'item_loan_rate',
        'cash_loan_tenor',
        'guarantor_one',
        'guarantor_two',
        'g1_phone_no',
        'g2_phone_no',
        'status',
        'reason_for_rejection',
        'user_id',
        'item_price',
        'item_name'
    ];

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class,'user_id')->withTrashed();
    }

    public  function incomes()
    {
        return$this->hasOne(Income::class);
    }


}
