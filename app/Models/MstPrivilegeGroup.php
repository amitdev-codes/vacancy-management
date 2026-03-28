<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstPrivilegeGroup extends Model
{
    use HasFactory;
    protected $table='mst_privilege_group';

    protected $fillable=['code','name_en','name_np'];
    public function scopeFilter($query)
    {
        return $query->where(['is_deleted',false]);
    }
}
