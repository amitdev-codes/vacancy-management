<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantExperienceInfo extends Model
{
    use HasFactory;
    protected $table='applicant_exp_info';
    public function scopeFilter($query,$value)
    {
        return $query->where([['applicant_id',$value],['is_deleted',false]]);
    }
}
