<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    /**
     * Get all unread notifications for authenticated user
     */
    public function unread(): JsonResponse
    {
        $notifications = auth()->user()->unreadNotifications()->take(10)->get();
        
        return response()->json([
            'count' => auth()->user()->unreadNotifications()->count(),
            'notifications' => $notifications->map(function ($notif) {
                $taskUrl = null;
                if ($notif->related_type === 'task') {
                    $taskUrl = route('developer.tasks.show', $notif->related_id);
                }
                
                return [
                    'id' => $notif->id,
                    'title' => $notif->title,
                    'message' => $notif->message,
                    'type' => $notif->type,
                    'is_read' => $notif->isRead(),
                    'related_id' => $notif->related_id,
                    'related_type' => $notif->related_type,
                    'task_url' => $taskUrl,
                    'created_at' => $notif->created_at->diffForHumans(),
                    'created_at_full' => $notif->created_at->format('M d, Y H:i'),
                ];
            }),
        ]);
    }

    /**
     * Get all notifications for authenticated user
     */
    public function index(): JsonResponse
    {
        $notifications = auth()->user()->notifications()->take(20)->get();
        
        return response()->json([
            'unread_count' => auth()->user()->unreadNotifications()->count(),
            'notifications' => $notifications->map(function ($notif) {
                $taskUrl = null;
                if ($notif->related_type === 'task') {
                    $taskUrl = route('developer.tasks.show', $notif->related_id);
                }
                
                return [
                    'id' => $notif->id,
                    'title' => $notif->title,
                    'message' => $notif->message,
                    'type' => $notif->type,
                    'is_read' => $notif->isRead(),
                    'related_id' => $notif->related_id,
                    'related_type' => $notif->related_type,
                    'task_url' => $taskUrl,
                    'created_at' => $notif->created_at->diffForHumans(),
                    'created_at_full' => $notif->created_at->format('M d, Y H:i'),
                ];
            }),
        ]);
    }

    /**
     * Mark a specific notification as read
     */
    public function markAsRead(Notification $notification): JsonResponse
    {
        if ($notification->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark a specific notification as unread
     */
    public function markAsUnread(Notification $notification): JsonResponse
    {
        if ($notification->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->markAsUnread();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(): JsonResponse
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    /**
     * Delete a notification
     */
    public function destroy(Notification $notification): JsonResponse
    {
        if ($notification->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->delete();

        return response()->json(['success' => true]);
    }
}

