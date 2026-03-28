<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliedApplicantEducationInfo extends Model
{
    use HasFactory;

    protected $table='applied_applicant_edu_info';

    public function eduLevel()
    {
        return $this->belongsTo(MstEduLevel::class, 'edu_level_id');
    }
}
