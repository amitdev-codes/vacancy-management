<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoksewaReport extends Model
{
    use HasFactory;
    public $table='lok_sewa_report';

    public function scopeFilter($query,$value)
    {
        return $query->where([['vacancy_ad_id',$value]]);
    }
    public function scopeDesignation($query,$value)
    {
        return $query->where([['designation_id',$value]]);
    }
}
