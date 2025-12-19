<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class checkout extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = ['user_id', 'package_id', 'transaction_id', 'payment_method' ,'total_amount','coupon_discount','currency_name','currency_icon','status'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Packages::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_discount');
    }
}
