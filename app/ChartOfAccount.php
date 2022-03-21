<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    //
    protected $fillable = [
        'id',
        'code',
        'name',
        'type_id',
    ];

    public function classifications()
    {
        return $this->belongsTo(AccountClassification::class,'type_id');
    }
    public function ledgers()
    {
        return $this->hasMany(GeneralLedger::class);
    }
}
