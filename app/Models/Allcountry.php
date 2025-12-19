<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allcountry extends Model
{
    use HasFactory;
    protected $table = 'allcountry';
    public function states(){
    	return $this->hasMany(Allstate::class,'country_id');
    }
}
