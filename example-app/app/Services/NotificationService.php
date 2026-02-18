<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Send a notification to all admin users.
     * Optionally exclude a specific user (e.g. the admin performing the action).
     */
    public static function notifyAdmins(
        string $title,
        string $message,
        string $type = 'admin_info',
        ?int $relatedId = null,
        ?string $relatedType = null,
        ?int $excludeUserId = null
    ): void {
        $admins = User::where('role', UserRole::ADMIN->value)->get();

        foreach ($admins as $admin) {
            if ($excludeUserId && $admin->id === $excludeUserId) {
                continue;
            }

            Notification::create([
                'user_id'      => $admin->id,
                'title'        => $title,
                'message'      => $message,
                'type'         => $type,
                'related_id'   => $relatedId,
                'related_type' => $relatedType,
            ]);
        }
    }

    /**
     * Send a notification to a single user.
     */
    public static function notify(
        int $userId,
        string $title,
        string $message,
        string $type = 'info',
        ?int $relatedId = null,
        ?string $relatedType = null
    ): void {
        Notification::create([
            'user_id'      => $userId,
            'title'        => $title,
            'message'      => $message,
            'type'         => $type,
            'related_id'   => $relatedId,
            'related_type' => $relatedType,
        ]);
    }
}
