<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SignupActivate extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
	    $url = url('/api/auth/signup/activate/'.$notifiable->activation_token);
		
        return (new MailMessage)
	        ->subject(__('auth.confirm_email_subject'))
            ->line(__('auth.confirm_email_line_1'))
            ->action(__('auth.confirm_account_button'), url($url))
            ->line(__('messages.thanks_note_email'));
    }
}
