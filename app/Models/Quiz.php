<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Support\Facades\App;
use App\Notifications\QuizResultApproved;

class Quiz extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Sluggable;
    protected $table = 'quizes';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'marks',
        'timer',
        'status',
        'reattempt',
        'type',
        'subject',
        'start_date',
        'end_date',
        'category',
        'fees',
        'approve_result'
    ];

    protected $appends = ['category_name'];

    public function objectives()
    {
        return $this->belongsTo(Objective::class)->withDefault();
    }

    public function Sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')->withDefault();
    }

    public function isBookmarkedByUser($userId)
    {
        return $this->bookmarks()->where('user_id', $userId)->exists();
    }

    public function bookmarks()
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withTimestamps();
    }

    public function questions()
    {
        return $this->hasMany(Subjective::class);
    }

    public function objectiveAnswers()
    {
        return $this->hasMany(ObjectiveAnswer::class);
    }

    public function subjectiveAnswers()
    {
        return $this->hasMany(SubjectiveAnswer::class);
    }

    public function objectiveQuestions()
    {
        return $this->hasMany(Objective::class, 'quiz_id');
    }

    public function approve()
    {
        $this->approve_result = 1;
        $this->save();

        $userIds = $this->type == 1
            ? $this->objectiveAnswers()->pluck('user_id')->unique()
            : $this->subjectiveAnswers()->pluck('user_id')->unique();

        $leaderboardController = App::make(LeaderboardController::class);

        $errors = [];
        foreach ($userIds as $userId) {
            try {
                $leaderboardController->store($userId, $this->id, $this->type);
            } catch (\Exception $e) {
                $errors[] = 'Error updating leaderboard for user' . $userId .  ':'  . $e->getMessage();
            }
        }

        if (!empty($errors)) {
            \Log::error(implode("\n", $errors));
        }
    }

    public function sendResultApprovedNotifications()
    {
        $participants = $this->objectiveAnswers->merge($this->subjectiveAnswers)
            ->map->user
            ->unique('id');

        foreach ($participants as $user) {
            $user->notify(new QuizResultApproved($this));
        }
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->name ?? null;
    }
}
