# Admin System Quick Setup Guide

## Step 1: Run Migrations

Make sure all migrations are up to date:

```bash
php artisan migrate
```

## Step 2: Create Admin Account

Run the admin seeder to create the default admin user:

```bash
php artisan db:seed --class=AdminUserSeeder
```

**Default Credentials:**
- Email: `admin@example.com`
- Password: `password`

⚠️ **IMPORTANT:** Change this password immediately!

## Step 3: Login and Access Admin Panel

1. Go to your application's login page
2. Login with:
   ```
   Email: admin@example.com
   Password: password
   ```

3. After login, navigate to:
   - Register new users: `/admin/register-user`
   - Manage users: `/admin/users`

## Step 4: Register Your First Users

As admin, you can now register:

1. **Customer** - Can create projects and tasks
2. **Developer** - Generic developer role
3. **Frontend Developer** - Frontend development focus
4. **Backend Developer** - Backend development focus with delete permissions
5. **Server Administrator** - Infrastructure/server management
6. **Additional Admins** - Other administrators

### Example Users to Create

```
1. Customer Account
   Name: John Customer
   Email: customer@example.com
   Role: customer

2. Frontend Developer
   Name: Jane Frontend
   Email: jane@example.com
   Role: frontend

3. Backend Developer
   Name: Bob Backend
   Email: bob@example.com
   Role: backend

4. Additional Admin
   Name: Sarah Admin
   Email: sarah@example.com
   Role: admin
```

## Available Admin Routes

### Register New User
```
GET  /admin/register-user  - Registration form
POST /admin/register-user  - Create new user
```

### Manage Users
```
GET    /admin/users           - List all users
GET    /admin/users/{id}      - View user details
PUT    /admin/users/{id}/role - Update user role
DELETE /admin/users/{id}      - Delete user
```

## Permissions by Role

### Admin
- ✓ Register users
- ✓ Manage all users
- ✓ Create tasks/projects
- ✓ Delete tasks/projects

### Customer
- ✓ Create tasks/projects
- ✗ Delete tasks/projects
- ✗ Register users

### Developers (Developer, Frontend, Backend, Server Admin)
- ✓ Create tasks/projects
- ✓ View assigned work
- Frontend/Backend/Server can ✓ delete tasks/projects

## Testing the System

### 1. Test Admin Login
```
POST /login
Content-Type: application/json

{
    "email": "admin@example.com",
    "password": "password"
}
```

### 2. Register a Customer User
```
POST /admin/register-user
Content-Type: application/json
Authorization: Bearer <admin_token>

{
    "name": "Test Customer",
    "email": "test_customer@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "role": "customer"
}
```

### 3. Update User Role
```
PUT /admin/users/{user_id}/role
Content-Type: application/json
Authorization: Bearer <admin_token>

{
    "role": "developer"
}
```

### 4. View All Users
```
GET /admin/users
Authorization: Bearer <admin_token>
```

## Changing Admin Password

### Using Artisan Tinker
```bash
php artisan tinker
```

Then in tinker:
```php
$user = User::where('email', 'admin@example.com')->first();
$user->password = bcrypt('new_password_here');
$user->save();
```

Or use a form in the UI (implement password change form if needed).

## Troubleshooting

### "Only admins can register users" Error
- Ensure you're logged in as an admin user
- Check the user's role in the database:
  ```bash
  php artisan tinker
  User::pluck('name', 'email', 'role');
  ```

### Migration Errors
- Ensure database is created and connected
- Run `php artisan migrate:fresh` if needed (warning: this deletes all data)

### Tables Not Found
- Run `php artisan migrate`
- Check database connection in `.env`

## Next Steps

1. ✓ Create initial admin account
2. ✓ Register customer and developer users
3. Implement permission gates in `AuthServiceProvider`
4. Add audit logging for admin actions
5. Create password reset functionality
6. Implement 2FA for admin accounts
7. Add role-specific dashboards

## Files Modified/Created

- ✓ `app/Enums/UserRole.php` - Updated with new roles
- ✓ `app/Http/Controllers/AdminUserController.php` - Admin controller
- ✓ `app/Http/Middleware/AdminOnly.php` - Admin middleware
- ✓ `app/Models/User.php` - Added authorization methods
- ✓ `app/Services/PermissionService.php` - Permission service
- ✓ `database/migrations/2026_02_18_000000_add_admin_role.php`
- ✓ `database/seeders/AdminUserSeeder.php`
- ✓ `resources/views/admin/register-user.blade.php`
- ✓ `resources/views/admin/users.blade.php`
- ✓ `routes/web.php` - Updated with admin routes
- ✓ `ADMIN_SYSTEM.md` - Full documentation

## Support

For the complete admin system documentation, see `ADMIN_SYSTEM.md`
