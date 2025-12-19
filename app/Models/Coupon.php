<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupons';
    protected $fillable = ['coupon_code', 'discount_type', 'amount', 'min_amount','max_amount','start_date', 'expiry_date', 'limit','code_display','active_user'];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
