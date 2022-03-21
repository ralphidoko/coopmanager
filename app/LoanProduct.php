<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanProduct extends Model
{
    //
    protected $fillable=[
        'id',
        'item_name',
        'item_price',
        'item_description',
    ];
}
