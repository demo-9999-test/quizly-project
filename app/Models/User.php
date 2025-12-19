<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity; // Import the trait
use Spatie\Activitylog\LogOptions; // Import LogOptions
use DB;

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasRoles, SoftDeletes, LogsActivity;

    protected $dates = ['deleted_at'];

    // Configure activity logging
    


    public function socialMedia()
    {
        return $this->hasMany(SocialMedia::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'role',
        'gender',
        'image',
        'age',
        'password',
        'status',
        'desc',
        'address',
        'city',
        'show_mobile',
        'show_email',
        'country',
        'state',
        'google_id',
        'facebook_id',
        'github_id',
        'gitlab_id',
        'amazon_id',
        'linkedin_id',
        'pincode',
        'coins',
        'score',
        'rank',
        'slug'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function createReferCode()
    {
        $seed = str_split('abcdefghijklmnopqrstuvwxyz'
            . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            . '0123456789!$&');
        shuffle($seed);
        $rand = '';
        $affiliate = Affiliate::first();
        $ref_id = $affiliate->ref_length;
        $randKeys = array_rand($seed, $ref_id);
        if (is_array($randKeys)) {
            foreach ($randKeys as $k) {
                $rand .= $seed[$k];
            }
        }
        return Str::upper($rand);
    }
    public function deletionRequest()
    {
        return $this->hasOne(AccountDeletionRequest::class);
    }
    public function routeNotificationForOneSignal()
    {
        return ['include_external_user_ids' => [$this->id . ""]];
    }
    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'assign_badges')->withTimestamps();
    }

    public function friendships()
    {
        return $this->hasMany(Friendship::class, 'user_id');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
            ->wherePivot('status', 'accepted');
    }
    public function bookmarks()
    {
        return $this->belongsToMany(Quiz::class, 'bookmarks')->withTimestamps();
    }
    // Implement the getActivitylogOptions method
    public function getActivitylogOptions(): LogOptions
    {
        $isLoggingEnabled = DB::table('settings')->value('activity_status') == '1';

        if ($isLoggingEnabled) {
            return LogOptions::defaults()
                ->logAll()
                ->setDescriptionForEvent(fn(string $eventName) => "User model has been {$eventName}");
        } else {
            return LogOptions::defaults()
                ->dontSubmitEmptyLogs()
                ->logOnly([]);
        }
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('images/users/' . $this->image) : null;
    }

    
}
