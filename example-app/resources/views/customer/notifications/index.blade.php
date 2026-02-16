@extends('customer.layouts.app')
@section('title', 'Notifications')

@section('content')
<style>
    .notif-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .notif-page-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
        margin: 0;
    }
    .notif-page-header .header-meta {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    .notif-count-badge {
        background: var(--primary);
        color: #fff;
        padding: 0.3rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .notif-bulk-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .notif-bulk-btn {
        padding: 0.45rem 1rem;
        font-size: 0.82rem;
        font-weight: 600;
        border: 1px solid #ccc;
        border-radius: 8px;
        background: #f8f9fa;
        color: #333;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }
    .notif-bulk-btn:hover {
        background: #e9ecef;
        border-color: var(--primary);
        color: var(--primary);
    }
    .notif-bulk-btn.btn-danger-outline:hover {
        background: #ffe0e0;
        border-color: #f44336;
        color: #f44336;
    }
    .notif-list {
        display: flex;
        flex-direction: column;
        gap: 0;
    }
    .notif-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        transition: all 0.2s ease;
        position: relative;
    }
    .notif-card:first-child {
        border-radius: 12px 12px 0 0;
    }
    .notif-card:last-child {
        border-radius: 0 0 12px 12px;
    }
    .notif-card:only-child {
        border-radius: 12px;
    }
    .notif-card + .notif-card {
        border-top: none;
    }
    .notif-card:hover {
        background: rgba(0, 31, 63, 0.02);
    }
    .notif-card.unread {
        background: rgba(0, 31, 63, 0.03);
        border-left: 3px solid var(--primary);
    }
    .notif-card .notif-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(0, 31, 63, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: var(--primary);
        font-size: 0.9rem;
    }
    .notif-card.unread .notif-icon {
        background: var(--primary);
        color: #fff;
    }
    .notif-body {
        flex: 1;
        min-width: 0;
    }
    .notif-body .notif-title {
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--text-dark);
        margin: 0 0 0.25rem 0;
    }
    .notif-card.unread .notif-title {
        font-weight: 700;
        color: var(--primary);
    }
    .notif-body .notif-message {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: 0 0 0.35rem 0;
        line-height: 1.4;
    }
    .notif-body .notif-time {
        font-size: 0.75rem;
        color: #999;
    }
    .notif-actions {
        display: flex;
        gap: 0.4rem;
        flex-shrink: 0;
        align-items: center;
    }
    .notif-action-btn {
        width: 32px;
        height: 32px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background: #f8f9fa;
        color: #666;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }
    .notif-action-btn:hover {
        background: #e9ecef;
        border-color: var(--primary);
        color: var(--primary);
    }
    .notif-action-btn.btn-mark-read:hover {
        background: #e8f5e9;
        border-color: #4caf50;
        color: #4caf50;
    }
    .notif-action-btn.btn-mark-unread:hover {
        background: rgba(0, 31, 63, 0.08);
        border-color: var(--primary);
        color: var(--primary);
    }
    .notif-action-btn.btn-notif-delete:hover {
        background: #ffe0e0;
        border-color: #f44336;
        color: #f44336;
    }
    .notif-empty {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-muted);
    }
    .notif-empty i {
        font-size: 3rem;
        opacity: 0.25;
        margin-bottom: 1rem;
    }
    .notif-toast {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        background: var(--primary);
        color: #fff;
        padding: 0.75rem 1.25rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        z-index: 9999;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 31, 63, 0.3);
    }
    .notif-toast.show {
        opacity: 1;
        transform: translateY(0);
    }
    @media (max-width: 576px) {
        .notif-card {
            flex-direction: column;
            gap: 0.75rem;
        }
        .notif-actions {
            align-self: flex-end;
        }
    }
</style>

<div class="notif-page-header">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <a href="{{ route('customer.dashboard') }}" class="notif-bulk-btn" style="text-decoration: none; padding: 0.4rem 0.85rem;">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <h1><i class="fas fa-bell me-2"></i>Notifications</h1>
        @if ($unreadCount > 0)
            <span class="notif-count-badge">{{ $unreadCount }} unread</span>
        @endif
    </div>
    @if ($notifications->count() > 0)
        <div class="notif-bulk-actions">
            @if ($unreadCount > 0)
                <button class="notif-bulk-btn" onclick="markAllRead()">
                    <i class="fas fa-check-double"></i> Mark All as Read
                </button>
            @endif
            <button class="notif-bulk-btn btn-danger-outline" onclick="deleteAllNotifications()">
                <i class="fas fa-trash-alt"></i> Delete All
            </button>
        </div>
    @endif
</div>

<div class="notif-list" id="notifList">
    @forelse ($notifications as $notif)
        @php
            $isUnread = $notif->isUnread();
            $taskUrl = null;
            if ($notif->related_type === 'task' && $notif->related_id) {
                $taskUrl = route('customer.tasks.show', $notif->related_id);
            }
        @endphp
        <div class="notif-card {{ $isUnread ? 'unread' : '' }}" id="notif-{{ $notif->id }}">
            <div class="notif-icon">
                @if ($notif->type === 'task_assigned')
                    <i class="fas fa-user-plus"></i>
                @elseif ($notif->type === 'task_status')
                    <i class="fas fa-sync-alt"></i>
                @elseif ($notif->type === 'task_completed')
                    <i class="fas fa-check-circle"></i>
                @else
                    <i class="fas fa-bell"></i>
                @endif
            </div>
            <div class="notif-body">
                <p class="notif-title">
                    @if ($taskUrl)
                        <a href="{{ $taskUrl }}" style="color: inherit; text-decoration: none;">{{ $notif->title }}</a>
                    @else
                        {{ $notif->title }}
                    @endif
                </p>
                <p class="notif-message">{{ $notif->message }}</p>
                <span class="notif-time">
                    <i class="fas fa-clock me-1"></i>{{ $notif->created_at->diffForHumans() }} &middot; {{ $notif->created_at->format('M d, Y H:i') }}
                </span>
            </div>
            <div class="notif-actions">
                @if ($isUnread)
                    <button class="notif-action-btn btn-mark-read" title="Mark as Read" onclick="toggleRead({{ $notif->id }}, true)">
                        <i class="fas fa-check"></i>
                    </button>
                @else
                    <button class="notif-action-btn btn-mark-unread" title="Mark as Unread" onclick="toggleRead({{ $notif->id }}, false)">
                        <i class="fas fa-envelope"></i>
                    </button>
                @endif
                <button class="notif-action-btn btn-notif-delete" title="Delete" onclick="deleteSingle({{ $notif->id }})">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    @empty
        <div class="notif-empty">
            <i class="fas fa-bell-slash d-block"></i>
            <p style="margin: 0; font-size: 1rem;">No notifications yet</p>
        </div>
    @endforelse
</div>

<div class="notif-toast" id="notifToast"></div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

    function showToast(msg) {
        const t = document.getElementById('notifToast');
        t.textContent = msg;
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 2500);
    }

    function toggleRead(id, markRead) {
        const endpoint = markRead ? `/api/notifications/${id}/read` : `/api/notifications/${id}/unread`;
        fetch(endpoint, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken } })
            .then(r => r.json())
            .then(() => { showToast(markRead ? 'Marked as read' : 'Marked as unread'); setTimeout(() => location.reload(), 400); })
            .catch(() => showToast('Something went wrong'));
    }

    function deleteSingle(id) {
        if (!confirm('Delete this notification?')) return;
        fetch(`/api/notifications/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken } })
            .then(r => r.json())
            .then(() => {
                document.getElementById('notif-' + id)?.remove();
                showToast('Notification deleted');
                if (!document.querySelector('.notif-card')) {
                    document.getElementById('notifList').innerHTML = '<div class="notif-empty"><i class="fas fa-bell-slash d-block"></i><p style="margin:0;font-size:1rem;">No notifications yet</p></div>';
                }
            })
            .catch(() => showToast('Something went wrong'));
    }

    function markAllRead() {
        fetch('/api/notifications/mark-all-read', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken } })
            .then(r => r.json())
            .then(() => { showToast('All marked as read'); setTimeout(() => location.reload(), 400); })
            .catch(() => showToast('Something went wrong'));
    }

    function deleteAllNotifications() {
        if (!confirm('Delete all notifications? This cannot be undone.')) return;
        fetch('/api/notifications/all', { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken } })
            .then(r => r.json())
            .then(() => { showToast('All notifications deleted'); setTimeout(() => location.reload(), 400); })
            .catch(() => showToast('Something went wrong'));
    }
</script>
@endsection
