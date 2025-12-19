<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description','sub_category_id'];

    protected $casts = [
        'sub_category_id' => 'array',
    ];

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class ,'sub_category_id')->withDefault();
    }
}
