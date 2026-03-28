<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstJobOpeningType extends Model
{
    use HasFactory;
    protected $table='mst_job_opening_type';
    protected $fillable=['id','code','name_en','name_np'];
    public function scopeFilter($query)
    {
        return $query->where(['is_deleted',false]);
    }
}
