<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    use HasFactory;
    protected $table = 'categories';

    protected $fillable = ['name', 'slug', 'description','parent_id','image','status','icon'];



    public function subcategories()
    {
        return $this->hasMany('App\Models\SubCategory', 'category_id');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
