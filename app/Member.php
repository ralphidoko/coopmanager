<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Member extends Model
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

    protected $fillable = ['id', 'first_name', 'middle_name', 'last_name', 'staff_no', 'residential_address',
        'office_location', 'department', 'designation', 'gender', 'state_of_origin', 'lga',
        'town', 'nok_fname', 'nok_mname', 'nok_lname', 'nok_address', 'nok_phone_number',
        'nok_email', 'nok_relationship', 'user_id', 'email', 'referee_one', 'referee_two',
        'certification', 'multiple_loan_permission', 'permission_count', 'approval_status',
        'approval_count', 'membership_status','member_id',
        ];


    public function users()
    {
        return $this->belongsTo(User::class,'user_id')->withTrashed();
    }
    public function applications()
    {
        return $this->belongsTo('App\Application');
    }

}
