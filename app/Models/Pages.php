<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pages extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pages';
    protected $fillable = ['title', 'slug', 'desc', 'page_link', 'status','position'];
}
