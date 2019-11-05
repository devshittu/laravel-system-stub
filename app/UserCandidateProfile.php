<?php

namespace App;

use App\Utils\Constants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCandidateProfile extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', Constants::DBC_ACAD_CLASS_ID, Constants::DBC_ACAD_SESS_ID, Constants::DBC_AVATAR,];
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
     * Get the academic sessions for the user/candidate.
     */
    public function academic_session()
    {
        return $this->belongsTo('App\AcademicSession');
    }
    /**
     * Get the academic class that owns the candidate applied to.
     */
    public function academic_class()
    {
        return $this->belongsTo('App\AcademicClass');
    }
}
