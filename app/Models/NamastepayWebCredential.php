<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NamastepayWebCredential extends Model
{
    use HasFactory;

    public function mst_payment_method(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(MstPaymentMethod::class,'id','counter_id');
    }

}
