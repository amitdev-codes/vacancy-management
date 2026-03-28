<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SajiloPayCredential extends Model
{
    use HasFactory;

    protected $table='sajilopay_credentials';
    protected $guarded =[];
}
