<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;


    protected $fillable=[
        'description',
        'posted_by',
        'account_id',
        'unit_price',
        'quantity',
        'total_price',
        'vendor',
        'product_service',
        'expense_number',
        'deleted_at',
        'status',
    ];

    public function users(){
        return $this->belongsTo(User::class,'user_id')->withTrashed();
    }
    public function accounts(){
        return $this->belongsTo(ChartOfAccount::class,'account_id');
    }
    public function salesperson(){
        return $this->belongsTo(User::class,'posted_by');
    }
}
