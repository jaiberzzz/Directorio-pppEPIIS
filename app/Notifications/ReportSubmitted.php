<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportSubmitted extends Notification
{
    use Queueable;

    public $practitioner;

    /**
     * Create a new notification instance.
     */
    public function __construct($practitioner)
    {
        $this->practitioner = $practitioner;
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'practitioner_id' => $this->practitioner->id,
            'student_name' => $this->practitioner->user->name,
            'message' => 'NUEVO INFORME: ' . $this->practitioner->user->name . ' ha enviado su informe final.',
            'timestamp' => now(),
        ];
    }
}
