<?php

namespace Tests\Feature\Api;

use App\Notifications\Channels\TelegramChannel;
use App\Notifications\NewContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MessageNotificationTest extends TestCase
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

    public function test_contact_message_is_stored_and_notifies_telegram()
    {
        Notification::fake();

        $this->postJson('/api/messages', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'Hello there',
            'message' => 'I would like to work with you.',
        ])->assertCreated();

        $this->assertDatabaseHas('messages', ['email' => 'jane@example.com']);

        Notification::assertSentOnDemand(
            NewContactMessage::class,
            function (NewContactMessage $notification, array $channels, object $notifiable) {
                return in_array(TelegramChannel::class, $channels, true)
                    && $notifiable->routes['telegram'] === '123456789'
                    && $notification->message->email === 'jane@example.com';
            }
        );
    }

    public function test_honeypot_submission_is_rejected_without_notification()
    {
        Notification::fake();

        $this->postJson('/api/messages', [
            'name' => 'Spam Bot',
            'email' => 'bot@example.com',
            'subject' => 'Buy now',
            'message' => 'Cheap offers inside.',
            'website' => 'https://spam.example',
        ])->assertUnprocessable();

        Notification::assertNothingSent();
    }

    public function test_no_notification_is_sent_when_telegram_is_not_configured()
    {
        config([
            'services.telegram.bot_token' => null,
            'services.telegram.chat_id' => null,
        ]);

        Notification::fake();

        $this->postJson('/api/messages', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'Hello there',
            'message' => 'I would like to work with you.',
        ])->assertCreated();

        Notification::assertNothingSent();
    }
}
