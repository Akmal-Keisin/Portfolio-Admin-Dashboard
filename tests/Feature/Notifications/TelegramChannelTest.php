<?php

namespace Tests\Feature\Notifications;

use App\Models\Message;
use App\Notifications\NewContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use RuntimeException;
use Tests\TestCase;

class TelegramChannelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.telegram.enabled' => true,
            'services.telegram.bot_token' => 'test-token',
            'services.telegram.chat_id' => '123456789',
        ]);
    }

    public function test_it_sends_the_notification_to_the_given_chat()
    {
        Http::fake([
            'api.telegram.org/*' => Http::response(['ok' => true, 'result' => ['message_id' => 1]]),
        ]);

        $message = Message::factory()->create([
            'name' => 'Jane Doe',
            'subject' => 'Hello there',
        ]);

        Notification::route('telegram', '123456789')->notifyNow(new NewContactMessage($message));

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.telegram.org/bottest-token/sendMessage'
                && $request['chat_id'] === '123456789'
                && str_contains($request['text'], 'Jane Doe')
                && str_contains($request['text'], 'Hello there');
        });
    }

    public function test_it_escapes_user_content()
    {
        Http::fake([
            'api.telegram.org/*' => Http::response(['ok' => true, 'result' => ['message_id' => 1]]),
        ]);

        $message = Message::factory()->create([
            'name' => '<b>Evil</b>',
            'subject' => '<script>alert(1)</script>',
        ]);

        Notification::route('telegram', '123456789')->notifyNow(new NewContactMessage($message));

        Http::assertSent(function (Request $request) {
            return str_contains($request['text'], '&lt;b&gt;Evil&lt;/b&gt;')
                && ! str_contains($request['text'], '<script>');
        });
    }

    public function test_it_throws_when_telegram_rejects_the_request()
    {
        Http::fake([
            'api.telegram.org/*' => Http::response([
                'ok' => false,
                'description' => 'Bad Request: chat not found',
            ], 400),
        ]);

        $message = Message::factory()->create();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Bad Request: chat not found');

        Notification::route('telegram', '123456789')->notifyNow(new NewContactMessage($message));
    }
}
