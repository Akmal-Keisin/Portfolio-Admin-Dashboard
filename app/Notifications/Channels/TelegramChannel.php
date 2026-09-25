<?php

namespace App\Notifications\Channels;

use App\Services\Telegram\TelegramClient;
use Illuminate\Notifications\Notification;

class TelegramChannel
{
    public function __construct(protected TelegramClient $client) {}

    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        $chatId = method_exists($notifiable, 'routeNotificationFor')
            ? $notifiable->routeNotificationFor('telegram', $notification)
            : null;

        $this->client->sendMessage(
            $notification->toTelegram($notifiable),
            $chatId ?? config('services.telegram.chat_id'),
        );
    }
}
