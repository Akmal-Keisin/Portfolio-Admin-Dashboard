<?php

namespace App\Console\Commands;

use App\Services\Telegram\TelegramClient;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use RuntimeException;

#[Signature('telegram:chat-id')]
#[Description('List Telegram chat IDs from recent bot updates')]
class TelegramChatId extends Command
{
    protected $signature = 'telegram:chat-id';

    protected $description = 'List Telegram chat IDs from recent bot updates';

    /**
     * Execute the console command.
     */
    public function handle(TelegramClient $client): int
    {
        if (blank(config('services.telegram.bot_token'))) {
            $this->error('TELEGRAM_BOT_TOKEN is not set.');

            return self::FAILURE;
        }

        try {
            $bot = $client->getMe();
            $updates = $client->getUpdates();
        } catch (RuntimeException $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        $this->info('Bot: @'.($bot['username'] ?? 'unknown'));

        $chats = collect($updates)
            ->map(fn (array $update) => $update['message']['chat']
                ?? $update['edited_message']['chat']
                ?? $update['channel_post']['chat']
                ?? $update['callback_query']['message']['chat']
                ?? null)
            ->filter()
            ->unique('id')
            ->values();

        if ($chats->isEmpty()) {
            $this->warn('No chats found. Open Telegram, send /start to your bot, then run this command again.');

            return self::SUCCESS;
        }

        $this->table(
            ['Chat ID', 'Type', 'Name', 'Username'],
            $chats->map(fn (array $chat) => [
                $chat['id'],
                $chat['type'] ?? '—',
                trim(($chat['title'] ?? '') ?: (($chat['first_name'] ?? '').' '.($chat['last_name'] ?? ''))),
                isset($chat['username']) ? '@'.$chat['username'] : '—',
            ])->all(),
        );

        $this->info('Add the chat ID to your .env as TELEGRAM_CHAT_ID.');

        return self::SUCCESS;
    }
}
