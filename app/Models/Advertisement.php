<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;
    protected $table = 'advertisements';
    protected $fillable = ['url', 'position','page_type', 'image'];
    public $timestamps = false;

    public function getImageUrlAttribute()
{
    return asset('images/advertisement/' . $this->image);
}

public function getPageTypeLabelAttribute()
{
    return [
        'hp' => 'Home Page',
        'ap' => 'About Page',
        'bp' => 'Blog Page',
        'tp' => 'Testimonial Page',
        'cp' => 'Contact Page',
    ][$this->page_type] ?? 'Unknown';
}

public function getPositionLabelAttribute()
{
    return [
        'bs' => 'Below Slider',
        'brc' => 'Below Recent Courses',
        'bbc' => 'Below Bundle Courses',
        'bt' => 'Below Testimonial',
    ][$this->position] ?? 'Unknown';
}

}
