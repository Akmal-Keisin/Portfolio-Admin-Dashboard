<?php

namespace App\Services\Telegram;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class TelegramClient
{
    /**
     * Determine whether the bot token and target chat are configured.
     */
    public static function configured(): bool
    {
        return (bool) config('services.telegram.enabled')
            && filled(config('services.telegram.bot_token'))
            && filled(config('services.telegram.chat_id'));
    }

    /**
     * Send a message to the given chat, defaulting to the configured chat.
     */
    public function sendMessage(string $text, int|string|null $chatId = null): void
    {
        $this->request('sendMessage', [
            'chat_id' => $chatId ?? config('services.telegram.chat_id'),
            'text' => $text,
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true,
        ]);
    }

    /**
     * Get the bot account details.
     *
     * @return array<string, mixed>
     */
    public function getMe(): array
    {
        return $this->request('getMe')['result'] ?? [];
    }

    /**
     * Get the most recent updates received by the bot.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getUpdates(): array
    {
        return $this->request('getUpdates')['result'] ?? [];
    }

    /**
     * Call a Telegram Bot API method.
     *
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     *
     * @throws RuntimeException
     */
    protected function request(string $method, array $payload = []): array
    {
        $token = config('services.telegram.bot_token');

        if (blank($token)) {
            throw new RuntimeException('Telegram bot token is not configured.');
        }

        try {
            $response = Http::timeout((int) config('services.telegram.timeout', 10))
                ->asJson()
                ->post("https://api.telegram.org/bot{$token}/{$method}", $payload);
        } catch (ConnectionException $e) {
            // Deliberately generic: the request URL contains the bot token.
            throw new RuntimeException('Telegram API is unreachable.', previous: $e);
        }

        if (! $response->successful() || $response->json('ok') !== true) {
            throw new RuntimeException(
                'Telegram API error: '.($response->json('description') ?? "HTTP {$response->status()}")
            );
        }

        return $response->json() ?? [];
    }
}
