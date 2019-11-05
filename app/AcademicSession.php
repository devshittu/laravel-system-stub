<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicSession extends Model
{
    use SoftDeletes;
    /**
     * Get the current system settings that owns the setting.
     */
    public function system_setting()
    {
        return $this->hasOne('App\SystemSetting');
    }

    public function user_candidate_profiles()
    {
        return $this->hasMany(UserCandidateProfile::class);
    }

    public function user_student_profiles()
    {
        return $this->hasMany(UserStudentProfile::class, 'enrollment_session_id');
    }


    public function user_student_transition_logs()
    {
        return $this->hasMany(UserStudentTransitionLog::class);
    }

}
