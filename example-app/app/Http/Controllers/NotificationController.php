<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    /**
     * Determine the correct task URL based on user role
     */
    private function getTaskUrl($notif): ?string
    {
        if ($notif->related_type !== 'task' || !$notif->related_id) {
            return null;
        }

        $user = auth()->user();
        if ($user->role === UserRole::CUSTOMER) {
            return route('customer.tasks.show', $notif->related_id);
        }

        return route('developer.tasks.show', $notif->related_id);
    }

    /**
     * Format a notification for JSON response
     */
    private function formatNotification($notif): array
    {
        return [
            'id' => $notif->id,
            'title' => $notif->title,
            'message' => $notif->message,
            'type' => $notif->type,
            'is_read' => $notif->isRead(),
            'related_id' => $notif->related_id,
            'related_type' => $notif->related_type,
            'task_url' => $this->getTaskUrl($notif),
            'created_at' => $notif->created_at->diffForHumans(),
            'created_at_full' => $notif->created_at->format('M d, Y H:i'),
        ];
    }

    /**
     * Get all unread notifications for authenticated user
     */
    public function unread(): JsonResponse
    {
        $notifications = auth()->user()->unreadNotifications()->take(10)->get();
        
        return response()->json([
            'count' => auth()->user()->unreadNotifications()->count(),
            'notifications' => $notifications->map(fn ($notif) => $this->formatNotification($notif)),
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
            'notifications' => $notifications->map(fn ($notif) => $this->formatNotification($notif)),
        ]);
    }

    /**
     * Show the notifications page
     */
    public function page()
    {
        $notifications = auth()->user()->notifications()->get();
        $unreadCount = auth()->user()->unreadNotifications()->count();
        $user = auth()->user();

        $view = $user->role === UserRole::CUSTOMER
            ? 'customer.notifications.index'
            : 'developer.notifications.index';

        return view($view, compact('notifications', 'unreadCount'));
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

    /**
     * Delete all notifications for authenticated user
     */
    public function destroyAll(): JsonResponse
    {
        auth()->user()->notifications()->delete();

        return response()->json(['success' => true]);
    }
}

