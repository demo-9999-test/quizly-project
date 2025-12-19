<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Quiz;

class QuizResultApproved extends Notification
{
    use Queueable;

    protected $quiz;

    /**
     * Create a new notification instance.
     */
    public function __construct(Quiz $quiz)
    {
        $this->quiz = $quiz;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The quiz result has been approved.')
                    ->action('View Result', url('/quiz-result/' . $this->quiz->id))
                    ->line('Thank you for participating in the quiz!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'quiz_id' => $this->quiz->id,
            'quiz_slug' => $this->quiz->slug,
            'quiz_name' => $this->quiz->name,
            'quiz_description' => $this->quiz->description,
            'quiz_image' => $this->quiz->image,
            'message' => "The result for quiz '{$this->quiz->name}' has been approved.",
            'approved_at' => now()->toDateTimeString(),
        ];
    }
}
