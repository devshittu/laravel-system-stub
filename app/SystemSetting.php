<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemSetting extends Model
{
    use SoftDeletes;
    /**
     * Get the academic sessions that owns the setting.
     */
    public function academic_session()
    {
        return $this->belongsTo('App\AcademicSession');
    }

    /**
     * Get the academic term that owns the setting.
     */
    public function academic_term()
    {
        return $this->belongsTo('App\AcademicTerm');
    }
}
