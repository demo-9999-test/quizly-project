<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Featuredcategory extends Model
{
    protected $fillable = ['name', 'category_ids', 'start_date', 'end_date','status'];

    protected $casts = [
        'category_ids' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function getCategories()
    {
        return Category::whereIn('id', $this->category_ids)->get();
    }

    public function isActive()
    {
        $now = Carbon::now();
        return $now->between($this->start_date, $this->end_date);
    }
}
