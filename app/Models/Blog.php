<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'blogs';
    protected $fillable = ['title', 'slug', 'category_id','thumbnail_img', 'banner_img', 'status', 'sticky', 'approved','is_featured', 'desc' ,'position'];


   protected $appends = ['category_name'];
    protected $hidden = ['postcategory'];

    public function postcategory()
    {
        return $this->belongsTo(PostCategory::class, 'category_id')->withDefault();
    }

    public function getCategoryNameAttribute()
    {
        return $this->postcategory->categories ?? null;
    }
}
