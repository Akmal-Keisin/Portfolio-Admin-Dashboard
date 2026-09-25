<?php

namespace App\Notifications;

use App\Models\Message;
use App\Notifications\Channels\TelegramChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\Attributes\Backoff;
use Illuminate\Queue\Attributes\Tries;
use Illuminate\Queue\SerializesModels;

#[Tries(3)]
#[Backoff(30, 120)]
class UnreadMessagesDigest extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @param  Collection<int, Message>  $messages
     */
    public function __construct(
        public int $unreadCount,
        public Collection $messages,
    ) {}

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
        $lines = $this->messages
            ->map(function (Message $message): string {
                $name = e($message->name);
                $subject = e($message->subject);

                return "• <b>{$name}</b> — {$subject}";
            })
            ->implode("\n");

        $count = $this->unreadCount;
        $url = e(config('app.url').'/messages');
        $remaining = $this->unreadCount - $this->messages->count();
        $more = $remaining > 0 ? "\n<i>…and {$remaining} more</i>" : '';

        return <<<HTML
        📥 <b>{$count} unread contact message(s)</b>

        {$lines}{$more}

        <a href="{$url}">Open inbox</a>
        HTML;
    }
}
