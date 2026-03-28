<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cms_User extends Model
{
    use HasFactory;
    protected $table = "cms_users";
    protected $fillable = ['name', 'email', 'mobile_no', 'id_cms_privileges', 'otp', 'password', 'password_changed'];

    protected $hidden = ['password'];
}
