<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Feedback;

class FeedbackCreated extends Notification
{
    use Queueable;

    public $feedback;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        // 存入数据库里的数据
        return [
            'feedback_id' => $this->feedback->id,
            'feedback_name' => $this->feedback->name,
            'feedback_phone' => $this->feedback->phone,
            'link' => admin_base_path('feedback/'. $this->feedback->id),
        ];
    }
}
