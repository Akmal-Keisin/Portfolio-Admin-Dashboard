<?php

namespace App\Console\Commands;

use App\Models\Message;
use App\Notifications\UnreadMessagesDigest;
use App\Services\Telegram\TelegramClient;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

#[Signature('telegram:digest')]
#[Description('Send a Telegram digest of unread inbox messages')]
class SendMessageDigest extends Command
{
    protected $signature = 'telegram:digest';

    protected $description = 'Send a Telegram digest of unread inbox messages';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (! TelegramClient::configured()) {
            $this->warn('Telegram is not configured; digest not sent.');

            return self::SUCCESS;
        }

        $messages = Message::query()
            ->where('status', 'inbox')
            ->where('is_read', false)
            ->latest()
            ->get();

        if ($messages->isEmpty()) {
            $this->info('No unread messages; digest not sent.');

            return self::SUCCESS;
        }

        Notification::route('telegram', config('services.telegram.chat_id'))
            ->notify(new UnreadMessagesDigest($messages->count(), $messages->take(8)->values()));

        $this->info("Digest queued for {$messages->count()} unread message(s).");

        return self::SUCCESS;
    }
}
