# Admin Role System Documentation

## Overview

This application now includes a comprehensive admin role system that allows administrators to:
- Register and manage user accounts
- Assign different roles to users (customer, developer, frontend, backend, server admin, admin)
- Control permissions based on user roles
- Manage user access levels

## User Roles

### 1. **Admin**
- Can register and manage all users
- Can assign/modify user roles
- Can delete user accounts
- Full access to all admin functions
- Cannot be deleted

### 2. **Customer**
- Can create projects
- Can create and assign tasks
- Can view assigned projects and tasks
- Cannot directly manage all users

### 3. **Developer**
- Can work on assigned tasks
- Can update task status and details
- Can view assigned projects
- Generic developer role

### 4. **Frontend Developer**
- Specialized developer role
- Can create tasks
- Can create projects
- Full developer permissions

### 5. **Backend Developer**
- Specialized developer role
- Can create tasks
- Can create projects
- Can delete tasks/projects
- Full developer permissions

### 6. **Server Administrator**
- Specialized developer role  
- Can create tasks and projects
- Can delete tasks and projects
- Full developer permissions

## Getting Started

### 1. Create Initial Admin User

Run the admin seeder to create the default admin account:

```bash
php artisan db:seed --class=AdminUserSeeder
```

**Default Admin Credentials:**
- Email: `admin@example.com`
- Password: `password`

⚠️ **IMPORTANT:** Change the admin password immediately in production!

### 2. Access Admin Panel

1. Login with admin credentials
2. Navigate to `/admin/register-user`
3. Or go to `/admin/users` to view all registered users

## Admin Features

### Register New User

**Route:** `/admin/register-user` (GET)

```
GET /admin/register-user
```

Shows a form to register new users with options for:
- Name
- Email
- Password
- Role

**Create New User (POST)**

```
POST /admin/register-user
```

Request body:
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "secure_password",
    "password_confirmation": "secure_password",
    "role": "customer"  // admin, customer, developer, frontend, backend, server_admin
}
```

### View All Users

**Route:** `/admin/users` (GET)

```
GET /admin/users
```

Displays paginated list of all registered users with options to:
- Edit user role
- Delete user account

### Update User Role

**Route:** `/admin/users/{user}/role` (PUT)

```
PUT /admin/users/{user}/role
```

Request body:
```json
{
    "role": "developer"  // frontend, backend, server_admin, customer, admin
}
```

Response:
```json
{
    "success": true,
    "message": "User role updated from Customer to Developer.",
    "user": { ... }
}
```

### Delete User

**Route:** `/admin/users/{user}` (DELETE)

```
DELETE /admin/users/{user}
```

Response:
```json
{
    "success": true,
    "message": "User John Doe has been deleted."
}
```

**Restrictions:**
- Cannot delete admin accounts
- Cannot delete yourself (your own account)

### View User Details

**Route:** `/admin/users/{user}` (GET)

```
GET /admin/users/{user}
```

Returns user details in JSON format.

## Permission System

### Role-Based Permissions

The permission system is built into the `UserRole` enum and accessible through:

#### Using User Model Methods

```php
$user = Auth::user();

// Check permissions
$user->isAdmin();
$user->isDeveloper();
$user->canCreateTask();
$user->canCreateProject();
$user->canDeleteProject();
$user->canDeleteTask();
$user->canRegisterUsers();
$user->canManageUsers();
```

#### Using PermissionService

```php
use App\Services\PermissionService;

$user = Auth::user();

// Check permissions
PermissionService::isAdmin($user);
PermissionService::isDeveloper($user);
PermissionService::canCreateTask($user);
PermissionService::canCreateProject($user);
PermissionService::canRegisterUsers($user);
PermissionService::canManageUsers($user);

// Get available roles for a user
$roles = PermissionService::getAvailableRoles($user);
```

### Permission Matrix

| Action | Admin | Customer | Developer | Frontend | Backend | Server Admin |
|--------|-------|----------|-----------|----------|---------|-------------|
| Register Users | ✓ | ✗ | ✗ | ✗ | ✗ | ✗ |
| Manage Users | ✓ | ✗ | ✗ | ✗ | ✗ | ✗ |
| Create Task | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ |
| Create Project | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ |
| Delete Task | ✓ | ✗ | ✗ | ✗ | ✓ | ✓ |
| Delete Project | ✓ | ✗ | ✗ | ✗ | ✓ | ✓ |

## Implementation Examples

### Protecting Routes

Protect routes with admin middleware:

```php
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/register-user', [AdminUserController::class, 'registrationForm']);
    Route::post('/register-user', [AdminUserController::class, 'store']);
    Route::resource('/users', AdminUserController::class);
});
```

Each route automatically checks if the user is authenticated. The controller methods verify admin status.

### Blade Template Authorization

```blade
@if (auth()->check() && auth()->user()->isAdmin())
    <a href="{{ route('admin.register-user.form') }}">Register User</a>
@endif

@if (auth()->check() && auth()->user()->canCreateTask())
    <button>Create Task</button>
@endif
```

### Controller Authorization

```php
public function store(Request $request)
{
    $user = auth()->user();

    if (!$user || !$user->canRegisterUsers()) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized. Only admins can register users.',
        ], 403);
    }

    // Create user...
}
```

## File Structure

New files created:

```
app/
├── Enums/
│   └── UserRole.php (updated)
├── Http/
│   ├── Controllers/
│   │   └── AdminUserController.php (new)
│   └── Middleware/
│       └── AdminOnly.php (new)
├── Models/
│   └── User.php (updated)
├── Services/
│   └── PermissionService.php (new)
database/
├── migrations/
│   └── 2026_02_18_000000_add_admin_role.php (new)
└── seeders/
    └── AdminUserSeeder.php (new)
resources/
└── views/
    └── admin/
        ├── register-user.blade.php (new)
        └── users.blade.php (new)
routes/
└── web.php (updated)
```

## Security Considerations

1. **Default Password:** Always change `admin@example.com` password in production
2. **Admin Protection:** Admin accounts cannot be deleted via API
3. **Self-Delete Prevention:** Users cannot delete their own accounts
4. **Role Validation:** All role assignments are validated against enum values
5. **Authentication Required:** All admin routes require authentication

## Next Steps

1. Update the default admin password
2. Create additional admin users if needed
3. Customize permission rules in `UserRole` enum as needed
4. Add CSRF tokens to all forms
5. Implement audit logging for admin actions
6. Add role-based access control (RBAC) gates in `AuthServiceProvider`

## Support

For issues or questions, refer to the controller implementation in:
- `app/Http/Controllers/AdminUserController.php`
- `app/Services/PermissionService.php`
- `app/Enums/UserRole.php`
