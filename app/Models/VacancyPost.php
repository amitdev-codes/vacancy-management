<?php

namespace App\Models;

use http\Env\Response;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacancyPost extends Model
{
    use HasFactory;
    protected $table='vacancy_post';
    public function scopeFilter($query,$value)
    {
        return $query->where([['vacancy_ad_id',$value],['is_deleted',false]]);
    }
    public function scopeSearch($query,$value,$design_id)
    {
        return $query->where([['vacancy_ad_id',$value],['designation_id',$design_id],['is_deleted',false]]);
    }
    public function designation():\Illuminate\Database\Eloquent\Relations\HasOne{
        return $this->hasOne(MstDesignation::class,'id','designation_id');
    }
    public function worklevel():\Illuminate\Database\Eloquent\Relations\HasOneThrough{
        return $this->hasOneThrough(MstWorkLevel::class,MstDesignation::class,'id','id','designation_id','work_level_id');
    }

    public function scopeSelectedCandidateFilter($query,$value)
    {
        return $query->where([['id',$value],['is_deleted',false]]);
    }

    public function scopeFilterByDesignation($query,$designation,$vacancy_ad)
    {
        return $query->where([['designation_id',$designation],['vacancy_ad_id',$vacancy_ad],['is_deleted',false]]);
    }

}
