<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    use HasFactory;
    protected $table = 'packages';
    protected $fillable = ['plan_id', 'pname', 'preward','pfeatures_id', 'plan_amount','status' ,'currency'];

    public function packageFeature()
    {
        return $this->belongsTo(PackageFeatures::class, 'id')->withDefault();
    }
}
