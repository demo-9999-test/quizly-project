<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportIssue extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'priority',
        'support_id',
        'status',
        'message',
        'image',
        'ticket_id'
    ];
    public function SupportType()
    {
        return $this->belongsTo(SupportType::class, 'support_id')->withDefault();
    }

    public function Users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
