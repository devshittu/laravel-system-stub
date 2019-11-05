<?php

namespace App;

use App\Utils\Constants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserStaffProfile extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', Constants::DBC_ACAD_CLASS_ID, Constants::DBC_ACAD_SESS_ID];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'exam_datetime'];
    /**
     * Get the user that owns the candidate_profile.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the class staff is holding that owns the candidate applied to.
     */
//    public function staff_classes()
//    {
//        return $this->hasMany('App\ClassStaff', 'user_id', 'user_id');
//    }
}
