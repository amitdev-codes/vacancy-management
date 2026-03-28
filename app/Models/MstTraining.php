<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstTraining extends Model
{
    use HasFactory;
    protected $table='mst_training';
    protected $fillable=['id','name_en'];
}
