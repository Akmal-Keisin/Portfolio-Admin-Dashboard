<?php

namespace App\Http\Controllers\Admin\Message;

use App\Http\Controllers\Controller;
use App\Http\Resources\Message\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ViewMessageController extends Controller
{
    /**
     * Display a listing of messages.
     */
    public function index(Request $request): Response
    {
        $status = $request->query('status', 'inbox');

        $messages = Message::query()
            ->where('status', $status)
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('admin/message/Index', [
            'messages' => MessageResource::collection($messages),
            'filters' => [
                'status' => $status,
            ],
        ]);
    }

    /**
     * Display the specified message.
     */
    public function show(Message $message): Response
    {
        // Mark as read when viewing
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return Inertia::render('admin/message/Show', [
            'message' => new MessageResource($message),
        ]);
    }
}
