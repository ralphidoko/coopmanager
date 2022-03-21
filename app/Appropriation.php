<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appropriation extends Model
{
    //
    protected $fillable=[
        'id',
        'education_reserve',
        'statutory_reserve',
        'proposed_dividend',
        'general_reserve',
        'financial_year',
        'proposed_main_dividend',
        'proposed_lpd',
    ];
}
