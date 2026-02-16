<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — ManageX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="{{ asset('css/modern.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary: #001f3f;
            --primary-dark: #001428;
            --white: #ffffff;
            --light-bg: #f8f9fa;
            --text-dark: #1a1a1a;
            --text-muted: #6c757d;
            --border: #e9ecef;
        }

        body {
            background-color: var(--white);
        }

        .navbar {
            background-color: var(--white);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0, 31, 63, 0.06);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary) !important;
            font-size: 1.4rem;
        }

        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            margin: 0 0.25rem;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-toggler:focus {
            box-shadow: none;
            outline: 1px solid var(--border);
        }

        main {
            padding: 2rem 0;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
            font-weight: 500;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: var(--white);
            border-color: var(--primary);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 31, 63, 0.06);
            background-color: var(--white);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 16px rgba(0, 31, 63, 0.1);
        }

        .table {
            background-color: var(--white);
        }

        .table thead th {
            background-color: var(--light-bg);
            border: none;
            font-weight: 600;
            color: var(--text-dark);
            padding: 1rem;
        }

        .table tbody td {
            border: none;
            padding: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .table tbody tr:hover {
            background-color: rgba(0, 31, 63, 0.02);
        }

        .badge {
            padding: 0.5rem 0.75rem;
            font-weight: 500;
            border-radius: 6px;
        }

        .badge-primary {
            background-color: rgba(0, 31, 63, 0.1);
            color: var(--primary);
        }

        .alert {
            border: none;
            border-radius: 8px;
            border-left: 4px solid;
        }

        .alert-success {
            background-color: #f0f8f4;
            border-left-color: #10b981;
            color: #065f46;
        }

        .link-accent {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .link-accent:hover {
            color: var(--primary-dark);
        }

        .fw-600 {
            font-weight: 600;
        }

        .text-accent {
            color: var(--primary);
        }

        .notification-item {
            padding: 0.75rem;
            border-bottom: 1px solid var(--border);
            cursor: pointer;
            transition: background-color 0.2s ease;
            user-select: none;
            word-break: break-word;
        }

        .notification-item:hover {
            background-color: var(--light-bg);
        }

        .notification-item.unread {
            background-color: rgba(0, 31, 63, 0.03);
            font-weight: 600;
            border-left: 3px solid var(--primary);
            padding-left: calc(0.75rem - 3px);
        }

        .notification-item.unread .notification-title {
            font-weight: 700;
            color: var(--primary);
        }

        .notification-item .notification-title {
            font-weight: 600;
            margin: 0 0 0.25rem 0;
            font-size: 0.9rem;
            color: var(--text-dark);
        }

        .notification-item .notification-message {
            margin: 0 0 0.5rem 0;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .notification-item .notification-time {
            font-size: 0.75rem;
            color: #999;
            margin-bottom: 0.5rem;
        }

        .notification-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            border-top: 1px solid rgba(0, 31, 63, 0.1);
        }

        .notification-actions button {
            flex: 1;
            padding: 0.4rem 0.6rem;
            font-size: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f8f9fa;
            color: #333;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
        }

        .notification-actions button i {
            font-size: 0.7rem;
        }

        .notification-actions button:hover {
            background-color: #e9ecef;
            border-color: var(--primary);
            color: var(--primary);
        }

        .notification-actions .btn-delete:hover {
            background-color: #ffe0e0;
            border-color: #f44336;
            color: #f44336;
        }

        .dropdown-menu {
            min-width: 380px !important;
            max-height: 500px;
            overflow-y: auto;
        }

        .dropdown-header {
            padding: 0.5rem 1rem !important;
            font-weight: 600;
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('customer.partials.nav')

    <main>
        <div class="container-fluid px-4">
            @if (session('success'))
                <div class="mb-4">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Load notifications on page load
        function loadNotifications() {
            fetch('/api/notifications/unread')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notificationBadge');
                    const count = data.count;
                    
                    if (count > 0) {
                        badge.textContent = count > 99 ? '99+' : count;
                        badge.style.display = 'inline-block';
                    } else {
                        badge.style.display = 'none';
                    }
                    
                    updateNotificationDropdown(data.notifications);
                })
                .catch(error => console.error('Error loading notifications:', error));
        }
        
        function updateNotificationDropdown(notifications) {
            const dropdown = document.querySelector('#notificationDropdown').nextElementSibling;
            const viewAllUrl = '{{ route("customer.notifications") }}';
            
            if (notifications.length === 0) {
                dropdown.innerHTML = `<li class="dropdown-header text-center py-3 text-muted">No notifications</li>
                    <li><hr class="dropdown-divider" style="margin: 0.5rem 0;"></li>
                    <li><a class="dropdown-item text-center py-2 small" href="${viewAllUrl}"><i class="fas fa-list me-1"></i>View All Notifications</a></li>`;
                return;
            }
            
            let html = '<li><h6 class="dropdown-header px-3 py-2">Notifications</h6></li>';
            
            notifications.forEach(notif => {
                const isUnread = !notif.is_read;
                const taskLink = notif.task_url ? notif.task_url : '';
                
                html += `
                    <li class="notification-item ${isUnread ? 'unread' : ''}" data-notif-id="${notif.id}" data-task-url="${taskLink}" style="border-left: ${isUnread ? '3px solid #001f3f' : 'none'}; padding-left: ${isUnread ? 'calc(0.75rem - 3px)' : '0.75rem'};">
                        <div class="notification-title" style="font-weight: ${isUnread ? '700' : '600'}; color: ${isUnread ? '#001f3f' : '#1a1a1a'};">${notif.title}</div>
                        <div class="notification-message">${notif.message}</div>
                        <div class="notification-time">${notif.created_at}</div>
                        <div class="notification-actions">
                            ${!isUnread ? `<button class="btn-check" onclick="event.stopPropagation(); markAsRead(${notif.id}); return false;"><i class="fas fa-check-circle"></i> Mark Unread</button>` : `<button class="btn-check" onclick="event.stopPropagation(); markAsRead(${notif.id}); return false;"><i class="fas fa-check"></i> Mark Read</button>`}
                            <button class="btn-delete" onclick="event.stopPropagation(); deleteNotification(${notif.id}); return false;"><i class="fas fa-trash"></i> Delete</button>
                        </div>
                    </li>
                `;
            });
            
            html += `<li><hr class="dropdown-divider" style="margin: 0.5rem 0;"></li>
                <li style="display: flex; gap: 0; border-top: none;">
                    <a class="dropdown-item text-center py-2 small" href="#" id="markAllRead" style="flex: 1; border-right: 1px solid #eee;"><i class="fas fa-check-double me-1"></i>Mark All Read</a>
                    <a class="dropdown-item text-center py-2 small text-danger" href="#" id="deleteAllBtn" style="flex: 1;"><i class="fas fa-trash-alt me-1"></i>Delete All</a>
                </li>
                <li><a class="dropdown-item text-center py-2 small fw-bold" href="${viewAllUrl}" style="background: #f8f9fa; border-radius: 0 0 8px 8px;"><i class="fas fa-list me-1"></i>View All Notifications</a></li>`;
            
            dropdown.innerHTML = html;
            
            // Add click handlers to notification items
            document.querySelectorAll('.notification-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    if (e.target.tagName !== 'BUTTON') {
                        const taskUrl = this.getAttribute('data-task-url');
                        if (taskUrl) {
                            window.location.href = taskUrl;
                        }
                    }
                });
            });
            
            document.getElementById('markAllRead')?.addEventListener('click', (e) => {
                e.preventDefault();
                markAllAsRead();
            });
            document.getElementById('deleteAllBtn')?.addEventListener('click', (e) => {
                e.preventDefault();
                deleteAllNotifications();
            });
        }
        
        function navigateToTask(taskUrl) {
            if (taskUrl && taskUrl !== '#') {
                window.location.href = taskUrl;
            }
        }
        
        function markAsRead(notificationId) {
            // Get the current notification item to determine if it's read or unread
            const notifItem = document.querySelector(`[data-notif-id="${notificationId}"]`);
            const isCurrentlyRead = notifItem && !notifItem.classList.contains('unread');
            
            const endpoint = isCurrentlyRead ? `/api/notifications/${notificationId}/unread` : `/api/notifications/${notificationId}/read`;
            
            fetch(endpoint, { 
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                }
            })
                .then(response => response.json())
                .then(() => loadNotifications())
                .catch(error => console.error('Error toggling notification state:', error));
        }
        
        function deleteNotification(notificationId) {
            if (confirm('Delete this notification?')) {
                fetch(`/api/notifications/${notificationId}`, { 
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    }
                })
                    .then(response => response.json())
                    .then(() => loadNotifications())
                    .catch(error => console.error('Error deleting notification:', error));
            }
        }
        
        function markAllAsRead() {
            fetch('/api/notifications/mark-all-read', { 
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                }
            })
                .then(response => response.json())
                .then(() => loadNotifications())
                .catch(error => console.error('Error marking notifications as read:', error));
        }

        function deleteAllNotifications() {
            if (!confirm('Delete all notifications? This cannot be undone.')) return;
            fetch('/api/notifications/all', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                }
            })
                .then(response => response.json())
                .then(() => loadNotifications())
                .catch(error => console.error('Error deleting all notifications:', error));
        }
        
        // Load notifications on page load
        document.addEventListener('DOMContentLoaded', loadNotifications);
        
        // Refresh notifications every 30 seconds
        setInterval(loadNotifications, 30000);
    </script>
    @stack('scripts')
</body>
</html>

