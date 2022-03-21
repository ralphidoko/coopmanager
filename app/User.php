<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use\Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable,SoftDeletes;

    //creating uuid for user model
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function($model){
            $model->id = Str::uuid();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone_no',
        'password',
        'passport_url',
        'membership_status',
        'is_admin',
        'last_login_at',
        'last_login_ip',
        'ippis_no',
        'date_admitted',
        'member_id',
        'is_verified'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function savings()
    {
        return $this->hasMany(Saving::class)->orderByDESC('id');
    }

    public function general_ledgers()
    {
        return $this->hasMany(GeneralLedger::class)->orderBy('id','DESC');
    }

    public function dividends(){
        return $this->hasMany(Dividend::class);
    }

    public function savingAuthorizations(){

        return $this->hasMany(SavingAuthorization::class);
    }

    public function incomes(){

        return $this->hasMany(Income::class);
    }

    public function expenses(){

        return $this->hasMany(Expense::class);
    }

    public function deducts(){

        return $this->hasOne(AuthorityToDeductPay::class);
    }
    public function banks(){
        return $this->hasOne(Bank::class);
    }

    public function electionContestants(){
        return $this->hasOne(ElectionContestant::class);
    }

    public function electionContests(){
        return $this->hasOne(ElectionContest::class);
    }
    public function members(){
        return $this->hasOne(Member::class);
    }

    public function logs(){
        return $this->hasMany(LogActivity::class);
    }

}
