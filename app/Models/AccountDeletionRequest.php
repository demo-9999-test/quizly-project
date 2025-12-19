<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountDeletionRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'reason', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reasonDetail()
    {
        return $this->belongsTo(Reason::class, 'reason', 'id')->withDefault();;
    }
}
