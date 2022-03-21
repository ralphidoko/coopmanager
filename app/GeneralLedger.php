<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralLedger extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'coa_id',
        'journal_id',
        'vendor',
        'reference',
        'move',
        'credit',
        'debit',
        'cumulative_balance',
        'deleted_at'
    ];

    public function journals()
    {
        return $this->belongsTo(Journal::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
    public function journal_types()
    {
        return $this->belongsTo(JournalType::class);
    }

    public function chart_of_accounts()
    {
        return $this->belongsTo(ChartOfAccount::class,'coa_id');
    }
}
