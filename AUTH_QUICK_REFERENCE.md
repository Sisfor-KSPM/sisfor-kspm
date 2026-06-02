# 🔐 Autentikasi Quick Reference

## 📍 Routes Reference

### User Routes

```
Login:              /login                  (GET/POST)
Register:           /register               (GET/POST)
Forgot Password:    /forgot-password        (GET/POST)
Reset Password:     /reset-password/{token} (GET/POST)
Dashboard:          /user/dashboard         (GET) - auth required
Logout:             /logout                 (POST) - auth required
```

### Admin Routes

```
Login:              /admin/login                  (GET/POST)
Forgot Password:    /admin/forgot-password        (GET/POST)
Reset Password:     /admin/reset-password/{token} (GET/POST)
Dashboard:          /admin/dashboard              (GET) - auth required
Logout:             /logout                       (POST) - auth required
```

---

## 🎯 Route Names untuk Blade/Controller

### User Auth

```
user.login              → /login
user.login.store        → POST /login
user.register           → /register
user.register.store     → POST /register
user.forgot-password    → /forgot-password
user.forgot-password.store → POST /forgot-password
user.reset-password     → /reset-password/{token}
user.reset-password.store  → POST /reset-password
user.dashboard          → /user/dashboard
```

### Admin Auth

```
admin.login             → /admin/login
admin.login.store       → POST /admin/login
admin.forgot-password   → /admin/forgot-password
admin.forgot-password.store → POST /admin/forgot-password
admin.reset-password    → /admin/reset-password/{token}
admin.reset-password.store → POST /admin/reset-password
admin.dashboard         → /admin/dashboard
```

### General

```
logout                  → POST /logout (dengan CSRF)
```

---

## 📝 Usage di Blade

### Redirect ke Login

```blade
{{ route('user.login') }}     → /login
{{ route('admin.login') }}    → /admin/login
```

### Form Action

```blade
<form action="{{ route('user.login.store') }}" method="POST">
    @csrf
    ...
</form>
```

### Check Auth

```blade
@auth
    User is logged in
    {{ Auth::user()->name }}
@endauth

@guest
    User not logged in
@endguest
```

### Check Role

```blade
@if(Auth::user()->role === 'admin')
    Is Admin
@else
    Is Regular User
@endif
```

### Redirect after Login

```blade
<a href="{{ route('user.dashboard') }}">Dashboard User</a>
<a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
```

---

## 🛡️ Middleware Usage

### Di Routes

```php
// Hanya untuk admin
Route::get('/path', Controller::class)->middleware('is.admin');

// Hanya untuk user (non-admin)
Route::get('/path', Controller::class)->middleware('is.user');

// Hanya untuk guest (non-login)
Route::get('/path', Controller::class)->middleware('is.guest');

// Auth + Admin
Route::get('/path', Controller::class)->middleware(['auth', 'is.admin']);
```

### Grouping Routes

```php
Route::middleware('is.admin')->group(function () {
    Route::get('/admin-only', ...);
});
```

---

## 🔍 User Model

### Attributes

```php
$user->id              // User ID
$user->name            // Nama lengkap
$user->username        // Username unik
$user->email           // Email unik
$user->role            // Role: 'ipb', 'umum', 'admin'
$user->created_at      // Waktu buat
$user->updated_at      // Waktu update
```

### Methods

```php
Auth::check()                              // Check if logged in
Auth::user()                               // Get current user
Auth::user()->role === 'admin'             // Check role
Hash::make($password)                      // Hash password
Hash::check($password, $hashedPassword)    // Verify password
Auth::login($user)                         // Login user
Auth::logout()                             // Logout
```

---

## 🧪 Testing Login

### User Login

```
URL:      /login
Input:    login (username/email), password, remember
Submit:   POST /login
Result:   Redirect to /user/dashboard
```

### Admin Login

```
URL:      /admin/login
Input:    login (username/email), password, remember
Note:     Hanya user dengan role='admin' bisa login
Submit:   POST /admin/login
Result:   Redirect to /admin/dashboard
```

### Register User

```
URL:      /register
Input:    name, username, email, password, password_confirmation
Submit:   POST /register
Result:   Auto-login & redirect to /user/dashboard
```

---

## 📧 Password Reset Flow

### User

```
1. Go to /forgot-password
2. Enter email
3. Check email for reset link
4. Click link: /reset-password/{token}
5. Enter new password
6. Submit & redirect to /login
```

### Admin

```
1. Go to /admin/forgot-password
2. Enter email
3. Check email for reset link
4. Click link: /admin/reset-password/{token}
5. Enter new password
6. Submit & redirect to /admin/login
```

---

## 🔐 Important Notes

- ✅ Passwords are hashed using Laravel's Hash (bcrypt)
- ✅ Reset tokens expire in 60 minutes (configurable in .env)
- ✅ CSRF protection on all forms
- ✅ Admin-only login restricted by role check
- ✅ Middleware ensures proper access control
- ✅ All user inputs are validated
- ✅ Error messages in Bahasa Indonesia

---

## 🛠️ Quick Fixes

### 404 on Login

- Check route name in form action
- Verify SessionAuthController exists
- Check if route is inside `guest` middleware

### Middleware Not Working

- Verify alias in `bootstrap/app.php`
- Check if middleware is applied to route
- Clear cache: `php artisan route:cache`

### Password Reset Not Sending

- Check `.env` MAIL\_\* configuration
- Verify email exists in database
- Check if token is properly generated
- Try `MAIL_MAILER=log` for testing

### Cannot Login as Admin

- Verify user role is 'admin' in database
- Check SQL: `SELECT * FROM users WHERE email='your@email.com';`
- Update role: `UPDATE users SET role='admin' WHERE id=1;`

---

## 📱 Forms

### Login Form Fields

```
- Username / Email (required)
- Password (required)
- Remember Me (checkbox, optional)
- CSRF Token
```

### Register Form Fields

```
- Name (required)
- Username (required, unique)
- Email (required, unique)
- Password (required, min 8 chars)
- Password Confirmation (required, must match)
- CSRF Token
```

### Forgot Password Form Fields

```
- Email (required, must exist in db)
- CSRF Token
```

### Reset Password Form Fields

```
- Email (required)
- Password (required, min 8 chars)
- Password Confirmation (required, must match)
- Token (hidden)
- CSRF Token
```

---

## 🚀 Production Checklist

- [ ] Email configuration set in .env
- [ ] Password reset timeout configured
- [ ] CSRF protection enabled
- [ ] Password validation rules reviewed
- [ ] Error messages tested
- [ ] Middleware properly applied
- [ ] Database migrations run
- [ ] Routes tested manually
- [ ] Logout functionality tested
- [ ] Error pages customized (optional)

---

**Generated**: 2026-06-02
**Last Updated**: 2026-06-02
