@extends('admin.layouts.app')
@section('title', 'Notifications')

@section('content')
<div class="container-fluid py-4 px-4">

    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-3">
                <i class="fas fa-arrow-left me-1"></i>Back
            </a>
            <h4 class="fw-700 mb-0" style="color: #001f3f;"><i class="fas fa-bell me-2"></i>Notifications</h4>
            @if ($unreadCount > 0)
                <span class="badge rounded-pill" style="background: #001f3f;">{{ $unreadCount }} unread</span>
            @endif
        </div>
        @if ($notifications->count() > 0)
            <div class="d-flex gap-2 flex-wrap">
                @if ($unreadCount > 0)
                    <button class="btn btn-outline-primary btn-sm rounded-3" onclick="markAllRead()">
                        <i class="fas fa-check-double me-1"></i>Mark All as Read
                    </button>
                @endif
                <button class="btn btn-outline-danger btn-sm rounded-3" onclick="deleteAllNotifications()">
                    <i class="fas fa-trash-alt me-1"></i>Delete All
                </button>
            </div>
        @endif
    </div>

    <!-- Notification List -->
    <div id="notifList">
        @forelse ($notifications as $notif)
            @php
                $isUnread = $notif->isUnread();
                $notifUrl = null;
                if ($notif->related_type === 'task' && $notif->related_id) {
                    try { $notifUrl = route('admin.tasks.show', $notif->related_id); } catch (\Exception $e) {}
                } elseif ($notif->related_type === 'user' && $notif->related_id) {
                    try { $notifUrl = route('admin.users.show', $notif->related_id); } catch (\Exception $e) {}
                } elseif ($notif->related_type === 'project' && $notif->related_id) {
                    try { $notifUrl = route('admin.projects.show', $notif->related_id); } catch (\Exception $e) {}
                }
            @endphp
            <div class="card mb-0" id="notif-{{ $notif->id }}" style="border-radius: 0; border-left: {{ $isUnread ? '3px solid #001f3f' : 'none' }}; {{ $isUnread ? 'background: rgba(0, 31, 63, 0.03);' : '' }} {{ $loop->first ? 'border-radius: 12px 12px 0 0;' : '' }} {{ $loop->last ? 'border-radius: 0 0 12px 12px;' : '' }} {{ $loop->first && $loop->last ? 'border-radius: 12px;' : '' }} border-bottom: 1px solid #e9ecef;">
                <div class="card-body d-flex align-items-start gap-3 py-3 px-4">
                    <!-- Icon -->
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; {{ $isUnread ? 'background: #001f3f; color: white;' : 'background: rgba(0, 31, 63, 0.08); color: #001f3f;' }}">
                        @if (in_array($notif->type, ['task_assigned', 'task_created']))
                            <i class="fas fa-plus-circle" style="font-size: 0.85rem;"></i>
                        @elseif (in_array($notif->type, ['task_status_updated', 'task_updated']))
                            <i class="fas fa-sync-alt" style="font-size: 0.85rem;"></i>
                        @elseif ($notif->type === 'task_deleted')
                            <i class="fas fa-trash-alt" style="font-size: 0.85rem;"></i>
                        @elseif (in_array($notif->type, ['project_created', 'project_deleted']))
                            <i class="fas fa-folder" style="font-size: 0.85rem;"></i>
                        @elseif ($notif->type === 'user_registered')
                            <i class="fas fa-user-plus" style="font-size: 0.85rem;"></i>
                        @elseif (in_array($notif->type, ['user_role_changed', 'user_status_changed']))
                            <i class="fas fa-user-edit" style="font-size: 0.85rem;"></i>
                        @elseif ($notif->type === 'user_deleted')
                            <i class="fas fa-user-minus" style="font-size: 0.85rem;"></i>
                        @else
                            <i class="fas fa-bell" style="font-size: 0.85rem;"></i>
                        @endif
                    </div>

                    <!-- Body -->
                    <div class="flex-grow-1" style="min-width: 0;">
                        <p class="mb-1" style="font-weight: {{ $isUnread ? '700' : '600' }}; font-size: 0.95rem; color: {{ $isUnread ? '#001f3f' : '#1a1a1a' }};">
                            @if ($notifUrl)
                                <a href="{{ $notifUrl }}" class="text-decoration-none" style="color: inherit;">{{ $notif->title }}</a>
                            @else
                                {{ $notif->title }}
                            @endif
                        </p>
                        <p class="text-muted mb-1" style="font-size: 0.85rem; line-height: 1.4;">{{ $notif->message }}</p>
                        <small class="text-muted" style="font-size: 0.75rem;">
                            <i class="fas fa-clock me-1"></i>{{ $notif->created_at->diffForHumans() }} &middot; {{ $notif->created_at->format('M d, Y H:i') }}
                        </small>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex gap-1 flex-shrink-0">
                        @if ($isUnread)
                            <button class="btn btn-sm btn-outline-success border rounded-2" title="Mark as Read" onclick="toggleRead({{ $notif->id }}, true)" style="width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-check" style="font-size: 0.75rem;"></i>
                            </button>
                        @else
                            <button class="btn btn-sm btn-outline-secondary border rounded-2" title="Mark as Unread" onclick="toggleRead({{ $notif->id }}, false)" style="width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-envelope" style="font-size: 0.75rem;"></i>
                            </button>
                        @endif
                        <button class="btn btn-sm btn-outline-danger border rounded-2" title="Delete" onclick="deleteSingle({{ $notif->id }})" style="width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-trash" style="font-size: 0.75rem;"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="card text-center py-5">
                <div class="card-body">
                    <i class="fas fa-bell-slash fa-3x text-muted mb-3" style="opacity: 0.25;"></i>
                    <p class="text-muted mb-0" style="font-size: 1rem;">No notifications yet</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Toast -->
<div id="notifToast" style="position: fixed; bottom: 2rem; right: 2rem; background: #001f3f; color: #fff; padding: 0.75rem 1.25rem; border-radius: 8px; font-size: 0.85rem; font-weight: 500; z-index: 9999; opacity: 0; transform: translateY(10px); transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0, 31, 63, 0.3);"></div>
@endsection

@push('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

    function showToast(msg) {
        const t = document.getElementById('notifToast');
        t.textContent = msg;
        t.style.opacity = '1';
        t.style.transform = 'translateY(0)';
        setTimeout(() => { t.style.opacity = '0'; t.style.transform = 'translateY(10px)'; }, 2500);
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
                if (!document.querySelector('[id^="notif-"]')) {
                    document.getElementById('notifList').innerHTML = '<div class="card text-center py-5"><div class="card-body"><i class="fas fa-bell-slash fa-3x text-muted mb-3" style="opacity:0.25;"></i><p class="text-muted mb-0" style="font-size:1rem;">No notifications yet</p></div></div>';
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
@endpush
