<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VwAdmitCard extends Model
{
    use HasFactory;

    protected $table='vw_admit_card';

    public function scopeFilter($query,$value)
    {
        return $query->where([['vacancy_post_id',$value]]);
    }
}
