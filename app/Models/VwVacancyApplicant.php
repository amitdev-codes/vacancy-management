<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VwVacancyApplicant extends Model
{
    use HasFactory;
    protected $table = "vw_vacancy_applicant";
    public function scopeFilter($query)
    {
        return $query->where(['is_deleted',false]);
    }
}
