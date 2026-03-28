<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VwVacancyPostApplicantProfile extends Model
{
    use HasFactory;
    protected $table='vw_vacancy_post_applicant_profile';
    protected $casts = [
        'is_open' => 'string',
        'nt_staff' => 'string',
        'is_female' => 'string',
        'is_madhesi' => 'string',
        'is_janajati' => 'string',
        'is_dalit' => 'string',
        'is_handicapped' => 'string',
        'is_remote_village' => 'string',
    ];
    public function scopeFilter($query)
    {
        return $query->where([['is_cancelled',false],['is_rejected',false],['is_paid',true]]);
    }
    public function getIsOpenAttribute($value):string
    {
         $unicodeChar = "\u{2713}";
        return $value===1?$unicodeChar:'-';

    }
    public function getNtStaffAttribute($value):string
    {
        return $value===1?'YES':'NO';
    }
    public function getIsFemaleAttribute($value):string
    {
        $unicodeChar = "\u{2713}";
        return $value===1?$unicodeChar:'-';
    }
    public function getIsMadhesiAttribute($value):string
    {
        $unicodeChar = "\u{2713}";
        return $value===1?$unicodeChar:'-';
    }
    public function getIsJanajatiAttribute($value):string
    {
        $unicodeChar = "\u{2713}";
        return $value===1?$unicodeChar:'-';
    }
    public function getIsDalitAttribute($value):string
    {
        $unicodeChar = "\u{2713}";
        return $value===1?$unicodeChar:'-';
    }
    public function getIsHandicappedAttribute($value):string
    {
        $unicodeChar = "\u{2713}";
        return $value===1?$unicodeChar:'-';
    }
    public function getIsRemoteVillageAttribute($value):string
    {
        $unicodeChar = "\u{2713}";
        return $value===1?$unicodeChar:'-';
    }
}
