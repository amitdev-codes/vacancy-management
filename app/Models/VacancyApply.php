<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;

class VacancyApply extends Model
{
    use HasFactory;
    protected $table = 'vacancy_apply';

    public function scopeFilter($query,$value)
    {
        
        return $query->where([['applicant_id',$value],['vacancy_apply.is_deleted',false],['vacancy_apply.is_paid',true],['vacancy_apply.fiscal_year_id',Session::get('fiscal_year_id')]]);
    }
}
