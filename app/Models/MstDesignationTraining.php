<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstDesignationTraining extends Model
{
    use HasFactory;
    protected $table='mst_designation_training';
    protected $fillable=['id','training_id'];
    public function scopeFilter($query,$value)
    {
        return $query->where([['designation_id',$value],['is_deleted',false]]);
    }

    public function training():\Illuminate\Database\Eloquent\Relations\HasOne{
        return $this->hasOne(MstTraining::class,'id','training_id');
    }
}
