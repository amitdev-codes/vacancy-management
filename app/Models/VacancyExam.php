<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacancyExam extends Model
{
    use HasFactory;
    protected $table='vacancy_exam';

    public function scopeFilter($query,$value)
    {
        return $query->where([['vacancy_exam.vacancy_post_id',$value],['vacancy_exam.is_deleted',false]]);
    }
    public function scopeAppliedapplicant($query,$value)
    {
        return $query->where([['applicant_id',$value]]);
    }
}
