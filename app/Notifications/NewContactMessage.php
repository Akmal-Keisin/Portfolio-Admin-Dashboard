<?php

namespace App\Notifications;

use App\Models\Message;
use App\Notifications\Channels\TelegramChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\Attributes\Backoff;
use Illuminate\Queue\Attributes\Tries;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

#[Tries(3)]
#[Backoff(30, 120)]
class NewContactMessage extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Message $message) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, class-string>
     */
    public function via(object $notifiable): array
    {
        return [TelegramChannel::class];
    }

    /**
     * Build the Telegram message body.
     */
    public function toTelegram(object $notifiable): string
    {
        $message = $this->message;

        $name = e($message->name);
        $email = e($message->email);
        $subject = e($message->subject);
        $excerpt = e(Str::limit($message->message, 300));
        $url = e(config('app.url')."/messages/{$message->id}");
        $sentAt = $message->created_at->format('M j, Y H:i').' '.config('app.timezone');

        return <<<HTML
        📬 <b>New contact message</b>

        <b>From:</b> {$name} &lt;{$email}&gt;
        <b>Subject:</b> {$subject}

        {$excerpt}

        <a href="{$url}">Open in dashboard</a> · {$sentAt}
        HTML;
    }
}
