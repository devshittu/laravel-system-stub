<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserStudentProfile extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'has_paid', 'enrollment_session_id', 'enrollment_class_id', ];

    /**
     * Get the user that owns the student_profile.
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
        return $this->belongsTo('App\AcademicSession', 'academic_session_id', 'enrollment_session_id');
    }
    /**
     * Get the academic class that owns the candidate applied to.
     */
    public function academic_class()
    {
        return $this->belongsTo('App\AcademicClass', 'academic_class_id', 'enrollment_class_id');
    }
}
