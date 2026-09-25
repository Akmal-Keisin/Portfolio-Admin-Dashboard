<?php

namespace App\Console\Commands;

use App\Services\Telegram\TelegramClient;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use RuntimeException;

#[Signature('telegram:test {message?}')]
#[Description('Send a test message to the configured Telegram chat')]
class TelegramTest extends Command
{
    protected $signature = 'telegram:test {message? : Custom message text}';

    protected $description = 'Send a test message to the configured Telegram chat';

    /**
     * Execute the console command.
     */
    public function handle(TelegramClient $client): int
    {
        if (! TelegramClient::configured()) {
            $this->error('Telegram is not configured. Set TELEGRAM_BOT_TOKEN and TELEGRAM_CHAT_ID first.');

            return self::FAILURE;
        }

        $text = $this->argument('message') ?? '✅ Telegram notifications are wired up.';

        try {
            $client->sendMessage($text);
        } catch (RuntimeException $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        $this->info('Test message sent to chat '.config('services.telegram.chat_id').'.');

        return self::SUCCESS;
    }
}
