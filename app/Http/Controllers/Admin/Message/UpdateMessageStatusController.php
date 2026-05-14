<?php

namespace App\Http\Controllers\Admin\Message;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UpdateMessageStatusController extends Controller
{
    /**
     * Toggle the read status of a message.
     */
    public function toggleRead(Message $message): RedirectResponse
    {
        $message->update(['is_read' => !$message->is_read]);

        return back();
    }

    /**
     * Toggle the important status of a message.
     */
    public function toggleImportant(Message $message): RedirectResponse
    {
        $message->update(['is_important' => !$message->is_important]);

        return back();
    }

    /**
     * Toggle the archive status of a message.
     */
    public function toggleArchive(Message $message): RedirectResponse
    {
        $newStatus = $message->status === 'inbox' ? 'archived' : 'inbox';
        $message->update(['status' => $newStatus]);

        $messageLabel = $newStatus === 'archived' ? 'archived' : 'moved to inbox';

        return back()->with('success', "Message {$messageLabel} successfully.");
    }
}
