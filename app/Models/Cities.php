<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;
    protected $table = 'cities';
    protected $fillable = ['name', 'country_id', 'state_id','pincode'];

    public function country() {
        return $this->belongsTo(Country::class, 'country_id', 'country_id')->withDefault();
    }

    public function states() {
        return $this->belongsTo(States::class, 'state_id', 'state_id')->withDefault();
    }
}
