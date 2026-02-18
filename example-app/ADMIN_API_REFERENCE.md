# Admin System - API Reference & Examples

## Authentication

All admin API endpoints require authentication. First, login to get a session or token.

### 1. Login as Admin

```bash
curl -X POST http://localhost:8000/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@example.com",
    "password": "password"
  }'
```

**Response:**
```json
{
  "user": {
    "id": 1,
    "name": "Admin",
    "email": "admin@example.com",
    "role": "admin"
  },
  "message": "Login successful"
}
```

## Admin API Endpoints

### 1. Register New User

**Endpoint:** `POST /admin/register-user`

**Description:** Create a new user account with specified role

#### Example: Register Customer User

```bash
curl -X POST http://localhost:8000/admin/register-user \
  -H "Content-Type: application/json" \
  -H "Cookie: XSRF-TOKEN=...; laravel_session=..." \
  -d '{
    "name": "John Smith",
    "email": "john.smith@example.com",
    "password": "SecurePass123!",
    "password_confirmation": "SecurePass123!",
    "role": "customer"
  }'
```

**Response (Success):**
```json
{
  "success": true,
  "message": "User John Smith (Customer) registered successfully.",
  "user": {
    "id": 2,
    "name": "John Smith",
    "email": "john.smith@example.com",
    "role": "customer",
    "created_at": "2026-02-18T10:30:00Z"
  }
}
```

**Response (Error - Email Exists):**
```json
{
  "success": false,
  "message": "Failed to register user: UNIQUE constraint failed"
}
```

#### Example: Register Backend Developer

```bash
curl -X POST http://localhost:8000/admin/register-user \
  -H "Content-Type: application/json" \
  -H "Cookie: XSRF-TOKEN=...; laravel_session=..." \
  -d '{
    "name": "Bob Backend",
    "email": "bob@example.com",
    "password": "Dev123!@#",
    "password_confirmation": "Dev123!@#",
    "role": "backend"
  }'
```

#### Example: Register Frontend Developer

```bash
curl -X POST http://localhost:8000/admin/register-user \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Jane Frontend",
    "email": "jane@example.com",
    "password": "Frontend123!",
    "password_confirmation": "Frontend123!",
    "role": "frontend"
  }'
```

#### Example: Register Another Admin

```bash
curl -X POST http://localhost:8000/admin/register-user \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Sarah Admin",
    "email": "sarah@example.com",
    "password": "AdminPass123!",
    "password_confirmation": "AdminPass123!",
    "role": "admin"
  }'
```

**Available Roles:**
- `admin` - Administrator (can register/manage users)
- `customer` - Customer (can create projects/tasks)
- `developer` - Generic developer
- `frontend` - Frontend developer
- `backend` - Backend developer
- `server_admin` - Server administrator

---

### 2. View Registration Form

**Endpoint:** `GET /admin/register-user`

**Description:** Get the user registration form (HTML)

```bash
curl -X GET http://localhost:8000/admin/register-user \
  -H "Cookie: XSRF-TOKEN=...; laravel_session=..."
```

**Response:** HTML form for user registration

---

### 3. List All Users

**Endpoint:** `GET /admin/users`

**Description:** Get paginated list of all users

```bash
curl -X GET http://localhost:8000/admin/users \
  -H "Cookie: XSRF-TOKEN=...; laravel_session=..."
```

**Query Parameters:**
- `page` - Page number (default: 1)
- `per_page` - Items per page (default: 15)

#### Example with Pagination

```bash
curl -X GET "http://localhost:8000/admin/users?page=2&per_page=10" \
  -H "Cookie: XSRF-TOKEN=...; laravel_session=..."
```

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Admin",
      "email": "admin@example.com",
      "role": "admin",
      "created_at": "2026-02-18T09:00:00Z"
    },
    {
      "id": 2,
      "name": "John Smith",
      "email": "john.smith@example.com",
      "role": "customer",
      "created_at": "2026-02-18T10:30:00Z"
    }
  ],
  "links": {
    "first": "http://localhost:8000/admin/users?page=1",
    "last": "http://localhost:8000/admin/users?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "per_page": 15,
    "to": 2,
    "total": 2
  }
}
```

---

### 4. View User Details

**Endpoint:** `GET /admin/users/{user_id}`

**Description:** Get details of specific user

```bash
curl -X GET http://localhost:8000/admin/users/2 \
  -H "Cookie: XSRF-TOKEN=...; laravel_session=..."
```

**Response:**
```json
{
  "id": 2,
  "name": "John Smith",
  "email": "john.smith@example.com",
  "role": "customer",
  "email_verified_at": null,
  "created_at": "2026-02-18T10:30:00Z",
  "updated_at": "2026-02-18T10:30:00Z"
}
```

---

### 5. Update User Role

**Endpoint:** `PUT /admin/users/{user_id}/role`

**Description:** Change a user's role

```bash
curl -X PUT http://localhost:8000/admin/users/2/role \
  -H "Content-Type: application/json" \
  -H "Cookie: XSRF-TOKEN=...; laravel_session=..." \
  -d '{
    "role": "developer"
  }'
```

**Response (Success):**
```json
{
  "success": true,
  "message": "User role updated from Customer to Developer.",
  "user": {
    "id": 2,
    "name": "John Smith",
    "email": "john.smith@example.com",
    "role": "developer",
    "created_at": "2026-02-18T10:30:00Z"
  }
}
```

#### Example: Promote to Backend Developer

```bash
curl -X PUT http://localhost:8000/admin/users/2/role \
  -H "Content-Type: application/json" \
  -d '{
    "role": "backend"
  }'
```

#### Example: Promote to Admin

```bash
curl -X PUT http://localhost:8000/admin/users/3/role \
  -H "Content-Type: application/json" \
  -d '{
    "role": "admin"
  }'
```

**Response (Error - Cannot modify admin):**
```json
{
  "success": false,
  "message": "Cannot modify admin account.",
  "status": 403
}
```

---

### 6. Delete User

**Endpoint:** `DELETE /admin/users/{user_id}`

**Description:** Delete a user account

```bash
curl -X DELETE http://localhost:8000/admin/users/2 \
  -H "Cookie: XSRF-TOKEN=...; laravel_session=..." \
  -X DELETE
```

**Response (Success):**
```json
{
  "success": true,
  "message": "User John Smith has been deleted."
}
```

**Response (Error - Cannot delete self):**
```json
{
  "success": false,
  "message": "You cannot delete your own account.",
  "status": 403
}
```

**Response (Error - Cannot delete admin):**
```json
{
  "success": false,
  "message": "Cannot delete admin accounts.",
  "status": 403
}
```

---

## Postman Collection

### Import Configuration

1. Create a new Postman Collection
2. Set base URL: `{{base_url}}` = `http://localhost:8000`
3. Add variable: `user_id` = `2` (or any user ID)

### Environment Setup

```json
{
  "name": "Admin API",
  "values": [
    {
      "key": "base_url",
      "value": "http://localhost:8000",
      "enabled": true
    },
    {
      "key": "user_id",
      "value": "2",
      "enabled": true
    }
  ]
}
```

### Collection Requests

#### 1. Login
```
POST /login
Body (raw JSON):
{
  "email": "admin@example.com",
  "password": "password"
}
```

#### 2. Register New Customer
```
POST /admin/register-user
Body (form-data):
- name: John Customer
- email: customer@example.com
- password: Password123!
- password_confirmation: Password123!
- role: customer
```

#### 3. Register New Developer
```
POST /admin/register-user
Body (raw JSON):
{
  "name": "Bob Backend",
  "email": "bob@example.com",
  "password": "Backend123!",
  "password_confirmation": "Backend123!",
  "role": "backend"
}
```

#### 4. List All Users
```
GET /admin/users
```

#### 5. View User Details
```
GET /admin/users/{{user_id}}
```

#### 6. Update User Role
```
PUT /admin/users/{{user_id}}/role
Body (raw JSON):
{
  "role": "developer"
}
```

#### 7. Delete User
```
DELETE /admin/users/{{user_id}}
```

---

## Common Use Cases

### Scenario 1: Create a New Project Team

**Step 1: Register Project Manager (Customer)**
```bash
curl -X POST http://localhost:8000/admin/register-user \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Alice Manager",
    "email": "alice@example.com",
    "password": "Pass123!",
    "password_confirmation": "Pass123!",
    "role": "customer"
  }'
```

**Step 2: Register Backend Developer**
```bash
curl -X POST http://localhost:8000/admin/register-user \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Charlie Backend",
    "email": "charlie@example.com",
    "password": "Pass123!",
    "password_confirmation": "Pass123!",
    "role": "backend"
  }'
```

**Step 3: Register Frontend Developer**
```bash
curl -X POST http://localhost:8000/admin/register-user \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Diana Frontend",
    "email": "diana@example.com",
    "password": "Pass123!",
    "password_confirmation": "Pass123!",
    "role": "frontend"
  }'
```

---

### Scenario 2: Promote Developer to Backend Lead

**Step 1: Get user ID** (from listing users)
```bash
curl -X GET http://localhost:8000/admin/users?page=1
```

**Step 2: View user details** (verify current role)
```bash
curl -X GET http://localhost:8000/admin/users/5
```

**Step 3: Update role to Backend Developer**
```bash
curl -X PUT http://localhost:8000/admin/users/5/role \
  -H "Content-Type: application/json" \
  -d '{
    "role": "backend"
  }'
```

---

## Error Handling

### Validation Errors (400)
```json
{
  "success": false,
  "errors": {
    "email": ["The email has already been taken."],
    "password": ["Password must be at least 8 characters"]
  }
}
```

### Not Authenticated (401)
```json
{
  "success": false,
  "message": "Unauthenticated"
}
```

### Not Authorized (403)
```json
{
  "success": false,
  "message": "Unauthorized. Only admins can register users."
}
```

### Not Found (404)
```json
{
  "success": false,
  "message": "User not found"
}
```

### Server Error (500)
```json
{
  "success": false,
  "message": "Failed to register user: Database error"
}
```

---

## Testing Checklist

- [ ] Login as admin
- [ ] Register customer user
- [ ] Register frontend developer
- [ ] Register backend developer
- [ ] Register server admin
- [ ] List all users
- [ ] View user details
- [ ] Update user role to developer
- [ ] Update user role to backend
- [ ] Try to delete non-admin user
- [ ] Try to delete yourself (should fail)
- [ ] Try to delete admin (should fail)

---

## Notes

- All endpoints require POST/PUT/DELETE to include CSRF token
- Session must be active (login first)
- Passwords must be at least 8 characters
- Email addresses must be unique
- Role must be valid enum value
