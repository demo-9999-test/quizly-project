<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id','package_id','transaction_id','payment_method','total_amount','coupon_discount','currency_name','currency_icon','status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
    public function package()
    {
        return $this->belongsTo(Packages::class, 'package_id')->withDefault();
    }
}
