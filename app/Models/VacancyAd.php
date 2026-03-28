<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class VacancyAd extends Model
{
    use HasFactory;
    protected $table='vacancy_ad';
    public function scopeFilter($query,$value)
    {
        return $query->where([['id',$value],['is_deleted',false]]);
    }
    public function scopeSearch($query)
    {
        $fiscal_year_id = Session::get('fiscal_year_id');
        return $query->where([['fiscal_year_id',$fiscal_year_id],['vacancy_ad.is_deleted',false]]);
    }
}
