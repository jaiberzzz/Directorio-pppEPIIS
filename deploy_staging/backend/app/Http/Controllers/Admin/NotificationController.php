<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Mark a notification as read and redirect to the target URL.
     */
    public function markAsRead($id)
    {
        $notification = DatabaseNotification::find($id);

        if ($notification) {
            $notification->markAsRead();

            // Redirect based on notification type
            if (isset($notification->data['practitioner_id'])) {
                return redirect()->route('admin.practitioners.review-report', $notification->data['practitioner_id']);
            }
        }

        return back();
    }
}
