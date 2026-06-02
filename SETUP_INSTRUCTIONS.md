# 🚀 Setup Instructions - Sistem Autentikasi KSPM

## ✅ Apa Yang Sudah Dibuat

Sistem autentikasi lengkap untuk aplikasi KSPM dengan:

- ✅ User registration & login
- ✅ Admin login dengan role-based access
- ✅ Forgot password & reset password (user & admin)
- ✅ Session-based authentication
- ✅ Role-based middleware (admin, user, guest)
- ✅ Consistent UI dengan Tailwind CSS
- ✅ Bahasa Indonesia
- ✅ Password hashing & security

---

## 📦 Files yang Dibuat

### Controllers

```
✅ app/Http/Controllers/SessionAuthController.php
```

### Middleware

```
✅ app/Http/Middleware/IsAdmin.php
✅ app/Http/Middleware/IsUser.php
✅ app/Http/Middleware/IsGuest.php
```

### Views

```
✅ resources/views/auth/login.blade.php
✅ resources/views/auth/register.blade.php
✅ resources/views/auth/forgot-password.blade.php
✅ resources/views/auth/reset-password.blade.php
✅ resources/views/admin/login-admin.blade.php
✅ resources/views/admin/lupapwadmin_session.blade.php
✅ resources/views/admin/reset-password-admin.blade.php
```

### Configuration

```
✅ routes/web.php (updated with auth routes)
✅ bootstrap/app.php (updated with middleware aliases)
✅ database/factories/UserFactory.php (updated with username & role)
```

### Documentation

```
✅ AUTHENTICATION_GUIDE.md
✅ AUTH_QUICK_REFERENCE.md
✅ SETUP_INSTRUCTIONS.md (file ini)
```

---

## 🔧 Langkah-Langkah Setup

### 1. Verify Database & Migration

```bash
# Database harus sudah di-setup
# Table 'users' dan 'password_reset_tokens' harus sudah ada

# Jalankan migration jika belum
php artisan migrate
```

### 2. Seed Test Data (Optional)

```bash
# Create test users untuk testing
php artisan db:seed

# Atau specific seeder
php artisan db:seed --class=UserSeeder
```

### 3. Clear Cache

```bash
php artisan cache:clear
php artisan route:cache
php artisan config:cache
```

### 4. Start Development Server

```bash
php artisan serve
```

---

## 🔐 Test Credentials

Setelah seed, gunakan:

### Admin User

```
Email/Username: admin
Password: password123
Role: admin
URL: http://localhost:8000/admin/login
```

### Regular User (IPB)

```
Email: user.ipb1@ipb.ac.id
Password: password
Role: ipb
URL: http://localhost:8000/login
```

### Regular User (Umum)

```
Email: user.umum1@kspm.com (atau sesuai seed output)
Password: password
Role: umum
URL: http://localhost:8000/login
```

---

## 📍 Routes Test Checklist

### User Registration

- [ ] Go to `http://localhost:8000/register`
- [ ] Fill form dengan data valid
- [ ] Submit
- [ ] Check: Auto-redirect ke `/user/dashboard`
- [ ] Check: User baru ada di database

### User Login

- [ ] Go to `http://localhost:8000/login`
- [ ] Input email/username & password
- [ ] Submit
- [ ] Check: Redirect ke `/user/dashboard`
- [ ] Check: Session aktif (user logout button visible)

### Admin Login

- [ ] Go to `http://localhost:8000/admin/login`
- [ ] Input admin credentials
- [ ] Submit
- [ ] Check: Redirect ke `/admin/dashboard`
- [ ] Check: Bisa akses admin pages

### Forgot Password

- [ ] Go to `http://localhost:8000/forgot-password`
- [ ] Input email
- [ ] Submit
- [ ] Check: "Link sent" message muncul
- [ ] Check: Email dikirim (check logs atau email server)

### Reset Password

- [ ] Click link di email
- [ ] Input password baru
- [ ] Submit
- [ ] Check: Redirect ke login
- [ ] Check: Bisa login dengan password baru

### Logout

- [ ] Click "Logout" button (biasanya di header/navbar)
- [ ] Check: Redirect ke home
- [ ] Check: Session cleared
- [ ] Try akses `/user/dashboard` → should redirect ke `/login`

---

## 🔌 Email Configuration (Optional)

Untuk mengirim email reset password:

### Option 1: Mailtrap (Testing)

Edit `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=noreply@kspm.com
MAIL_FROM_NAME="KSPM"
```

### Option 2: Log Driver (Development)

Edit `.env`:

```env
MAIL_MAILER=log
```

Check di: `storage/logs/laravel.log`

### Option 3: Production Email

Gunakan service email production (Gmail, SendGrid, AWS SES, dll)

---

## 📝 Customization Tips

### 1. Ubah Expiry Time Password Reset

File: `.env`

```env
PASSWORD_RESET_TIMEOUT=3600  # Dalam detik (default 1 jam)
```

### 2. Ubah Default Role untuk User Baru

File: `app/Http/Controllers/SessionAuthController.php`
Method: `storeUserRegister()`

```php
'role' => 'umum',  // Ubah sesuai kebutuhan
```

### 3. Ubah Validasi Password

File: `app/Http/Controllers/SessionAuthController.php`
Method: `storeUserRegister()`

```php
'password' => 'required|string|min:8|confirmed',  // min:8 untuk minimum 8 chars
```

### 4. Ubah Redirect Setelah Login

File: `app/Http/Controllers/SessionAuthController.php`

For user:

```php
return redirect()->route('user.dashboard');  // Ubah sesuai route
```

For admin:

```php
return redirect()->route('admin.dashboard');  // Ubah sesuai route
```

### 5. Custom Email Template

Create file: `resources/views/emails/reset-password.blade.php`
Atau modify di: `app/Notifications/ResetPasswordNotification.php`

---

## 🆘 Troubleshooting

### Error: Route Not Found

```
Solusi:
1. Check route name di form action
2. Run: php artisan route:cache
3. Verify SessionAuthController imported di web.php
```

### Error: 404 on Admin Login

```
Solusi:
1. Verify route: http://localhost:8000/admin/login
2. Check route registered di routes/web.php
3. Verify admin/login-admin.blade.php exists
```

### Error: Middleware Not Applied

```
Solusi:
1. Check bootstrap/app.php has middleware aliases
2. Run: php artisan route:cache
3. Verify route has middleware(['auth', 'is.admin'])
```

### Error: Password Reset Not Sending

```
Solusi:
1. Check .env MAIL_* configuration
2. Try MAIL_MAILER=log untuk testing
3. Check storage/logs/laravel.log untuk log
4. Verify password_reset_tokens table exists
```

### Error: Cannot Login as Admin

```
Solusi:
1. Check user role di database: SELECT * FROM users;
2. Verify role = 'admin'
3. Update jika perlu: UPDATE users SET role='admin' WHERE id=1;
```

### Error: Session Not Persisting

```
Solusi:
1. Check .env SESSION_DRIVER=database (atau file)
2. Verify sessions table exists (jika database)
3. Clear session: php artisan session:table (jika belum)
```

---

## 🔄 Database Troubleshooting

### Fresh Database Setup

```bash
# Reset database sepenuhnya
php artisan migrate:fresh --seed

# Atau manual
php artisan migrate:reset
php artisan migrate
php artisan db:seed
```

### Check Password Reset Table

```sql
SELECT * FROM password_reset_tokens;
```

### Check Users Table

```sql
SELECT id, name, username, email, role FROM users;
```

### Create Admin Manually (SQL)

```sql
INSERT INTO users (name, username, email, password, role, created_at, updated_at)
VALUES ('Admin KSPM', 'admin', 'admin@kspm.com', '$2y$12/...hashed_password...', 'admin', NOW(), NOW());
```

---

## 🧪 Testing Endpoints

### User Registration

```bash
curl -X POST http://localhost:8000/register \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "name=Test User&username=testuser&email=test@example.com&password=password&password_confirmation=password"
```

### User Login

```bash
curl -X POST http://localhost:8000/login \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "login=testuser&password=password"
```

### Admin Login

```bash
curl -X POST http://localhost:8000/admin/login \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "login=admin&password=password123"
```

---

## 📚 File Referensi

Untuk penjelasan lengkap, lihat:

- `AUTHENTICATION_GUIDE.md` - Dokumentasi komprehensif
- `AUTH_QUICK_REFERENCE.md` - Quick reference routes & usage

---

## ✨ Features Ready

- ✅ User Registration (validasi, unique username/email)
- ✅ User Login (username atau email)
- ✅ Admin Login (role-based)
- ✅ Forgot Password (email verification)
- ✅ Reset Password (token-based, time-limited)
- ✅ Logout
- ✅ Remember Me
- ✅ Password Hashing (bcrypt)
- ✅ CSRF Protection
- ✅ Session Management
- ✅ Role-Based Middleware
- ✅ Error Handling & Validation
- ✅ Flash Messages
- ✅ Responsive UI (Tailwind CSS)
- ✅ Bahasa Indonesia

---

## 🎯 Next Steps (Future Enhancement)

Optional jika diperlukan kemudian:

1. Email verification untuk user baru
2. Two-factor authentication (2FA) untuk admin
3. OAuth/Social login (Google, GitHub)
4. User profile page
5. Change password feature
6. Login history & activity log
7. IP whitelist untuk admin
8. CAPTCHA untuk login
9. Account deactivation
10. Admin user management dashboard

---

## 📞 Support

Jika ada pertanyaan atau error, periksa:

1. Error messages di browser developer console
2. Laravel log: `storage/logs/laravel.log`
3. Database consistency: Check users & password_reset_tokens table
4. Route verification: `php artisan route:list | grep -i auth`
5. Documentation files di root project

---

## ✅ Verification Checklist

Sebelum go live:

- [ ] Database migrations berjalan
- [ ] Test users berhasil di-seed
- [ ] Bisa register user baru
- [ ] Bisa login sebagai user
- [ ] Bisa login sebagai admin
- [ ] Logout berfungsi
- [ ] Middleware protection bekerja
- [ ] Email configuration setup (jika needed)
- [ ] Error pages customized (optional)
- [ ] Password hashing verified
- [ ] Routes tested manual & automated

---

**Created**: 2026-06-02  
**Version**: 1.0  
**Status**: Ready for Implementation ✨
