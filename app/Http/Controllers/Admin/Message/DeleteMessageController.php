<?php

namespace App\Http\Controllers\Admin\Message;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;

class DeleteMessageController extends Controller
{
    /**
     * Remove the specified message from storage.
     */
    public function __invoke(Message $message): RedirectResponse
    {
        $message->delete();

        return to_route('admin.messages.index')->with('success', 'Message deleted successfully.');
    }
}
