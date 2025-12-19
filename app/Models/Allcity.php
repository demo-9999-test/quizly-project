<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allcity extends Model
{
    use HasFactory;
    protected $table = 'cities';
    protected $fillable = ['name', 'state_id','pincode'];

    public function state(){
    	return $this->belongsTo(Allstate::class,'state_id','id')->withDefault();
    }
}
