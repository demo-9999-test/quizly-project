<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'description','category_id'];

    public function categories()
    {
        return $this->belongsTo(Category::class,'category_id')->withDefault();
    }

    public function childcategories()
    {
        return $this->hasMany(ChildCategory::class ,'sub_category_id');
    }
}
