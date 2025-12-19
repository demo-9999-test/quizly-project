<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allstate extends Model
{
    use HasFactory;
    protected $table = 'allstates';
    protected $fillable = ['name', 'country_id'];
    public $timestamps = false;

    public function country() {
        return $this->belongsTo(Allcountry::class, 'country_id', 'id')->withDefault();
    }
    public function city(){
    	return $this->hasMany(Allcity::class,'state_id');
    }
}
