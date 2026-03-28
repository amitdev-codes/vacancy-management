<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantEduInfo extends Model
{
    use HasFactory;
    protected $table='applicant_edu_info';

    public function scopeFilter($query,$value)
    {
        return $query->where([['applicant_id',$value],['is_deleted',false]]);
    }
    public function degree():\Illuminate\Database\Eloquent\Relations\HasOne{
        return $this->hasOne(MstEduDegree::class,'id','edu_degree_id');
    }
}
