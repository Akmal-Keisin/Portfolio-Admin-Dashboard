<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Notifications\NewContactMessage;
use App\Services\Telegram\TelegramClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;

class MessageController extends Controller
{
    /**
     * Store a newly created message in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'website' => ['nullable', 'string', 'max:255'],
        ]);

        // Honeypot check: if 'website' is filled, it's a bot
        if (! empty($validated['website'])) {
            throw ValidationException::withMessages([
                'message' => 'Invalid submission.',
            ]);
        }

        $message = Message::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if (TelegramClient::configured()) {
            Notification::route('telegram', config('services.telegram.chat_id'))
                ->notify(new NewContactMessage($message));
        }

        return response()->json([
            'message' => 'Your message has been sent successfully!',
        ], 201);
    }
}
