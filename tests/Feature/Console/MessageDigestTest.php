<?php

namespace Tests\Feature\Console;

use App\Models\Message;
use App\Notifications\UnreadMessagesDigest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MessageDigestTest extends TestCase
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

    public function test_it_sends_a_digest_of_unread_inbox_messages()
    {
        Notification::fake();

        Message::factory()->count(2)->create(['status' => 'inbox', 'is_read' => false]);
        Message::factory()->create(['status' => 'inbox', 'is_read' => true]);
        Message::factory()->create(['status' => 'archived', 'is_read' => false]);

        $this->artisan('telegram:digest')->assertSuccessful();

        Notification::assertSentOnDemand(
            UnreadMessagesDigest::class,
            fn (UnreadMessagesDigest $notification) => $notification->unreadCount === 2
                && $notification->messages->count() === 2
        );
    }

    public function test_it_does_not_send_when_there_are_no_unread_messages()
    {
        Notification::fake();

        Message::factory()->create(['status' => 'inbox', 'is_read' => true]);

        $this->artisan('telegram:digest')->assertSuccessful();

        Notification::assertNothingSent();
    }

    public function test_it_does_not_send_when_telegram_is_not_configured()
    {
        config([
            'services.telegram.bot_token' => null,
            'services.telegram.chat_id' => null,
        ]);

        Notification::fake();

        Message::factory()->create(['status' => 'inbox', 'is_read' => false]);

        $this->artisan('telegram:digest')->assertSuccessful();

        Notification::assertNothingSent();
    }
}
