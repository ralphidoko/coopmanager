<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountClassification extends Model
{
    //
    protected $fillable = [
        'name',
    ];

    public function chart_of_accounts()
    {
        return $this->hasMany(ChartOfAccount::class);
    }
}
