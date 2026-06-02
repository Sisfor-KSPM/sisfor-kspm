# Dokumentasi Sistem Autentikasi KSPM

## 📋 Ringkasan

Sistem autentikasi session-based yang lengkap dengan login, register, forgot password, dan reset password untuk user dan admin.

---

## 📁 File yang Dibuat

### 1. **Controller** - `app/Http/Controllers/SessionAuthController.php`

Menangani semua logic autentikasi berbasis session untuk user dan admin.

**Methods:**

- User Authentication:
    - `showUserLogin()` - Tampilkan form login user
    - `storeUserLogin()` - Proses login user
    - `showUserRegister()` - Tampilkan form register
    - `storeUserRegister()` - Proses registrasi user
    - `showUserForgotPassword()` - Tampilkan form lupa password user
    - `storeUserForgotPassword()` - Proses permintaan reset password user
    - `showUserResetPassword()` - Tampilkan form reset password user
    - `storeUserResetPassword()` - Proses reset password user

- Admin Authentication:
    - `showAdminLogin()` - Tampilkan form login admin
    - `storeAdminLogin()` - Proses login admin (validasi role='admin')
    - `showAdminForgotPassword()` - Tampilkan form lupa password admin
    - `storeAdminForgotPassword()` - Proses permintaan reset password admin
    - `showAdminResetPassword()` - Tampilkan form reset password admin
    - `storeAdminResetPassword()` - Proses reset password admin

- General:
    - `logout()` - Logout user/admin

---

### 2. **Middleware** (3 file)

#### a) `app/Http/Middleware/IsAdmin.php`

- Memastikan user sudah login dan memiliki role 'admin'
- Redirect ke home jika tidak memiliki akses

#### b) `app/Http/Middleware/IsUser.php`

- Memastikan user sudah login dan bukan admin
- Redirect ke home jika user adalah admin

#### c) `app/Http/Middleware/IsGuest.php`

- Memastikan user belum login
- Redirect ke dashboard sesuai role jika sudah login

---

### 3. **Views** (7 file)

#### User Authentication

1. **`resources/views/auth/login.blade.php`**
    - Form login untuk user
    - Input: username/email dan password
    - Link ke register dan forgot password

2. **`resources/views/auth/register.blade.php`**
    - Form registrasi user
    - Input: name, username, email, password, password_confirmation
    - Validasi duplicate username/email
    - Role default: 'umum'

3. **`resources/views/auth/forgot-password.blade.php`**
    - Form lupa password user
    - Input: email
    - Menampilkan pesan sukses setelah submit

4. **`resources/views/auth/reset-password.blade.php`**
    - Form reset password user
    - Input: email, password, password_confirmation, token
    - Validasi token expiration

#### Admin Authentication

5. **`resources/views/admin/login-admin.blade.php`**
    - Form login untuk admin (session-based)
    - Input: username/email dan password
    - Link ke forgot password
    - Validasi role='admin'

6. **`resources/views/admin/lupapwadmin_session.blade.php`**
    - Form lupa password admin
    - Input: email
    - Menampilkan pesan sukses setelah submit

7. **`resources/views/admin/reset-password-admin.blade.php`**
    - Form reset password admin
    - Input: email, password, password_confirmation, token
    - Validasi token expiration

---

## 🛣️ Routes yang Ditambahkan

### Guest Routes (middleware: `guest`)

```
GET  /login                          → showUserLogin
POST /login                          → storeUserLogin
GET  /register                       → showUserRegister
POST /register                       → storeUserRegister
GET  /forgot-password                → showUserForgotPassword
POST /forgot-password                → storeUserForgotPassword
GET  /reset-password/{token}         → showUserResetPassword
POST /reset-password                 → storeUserResetPassword
GET  /admin/login                    → showAdminLogin
POST /admin/login                    → storeAdminLogin
GET  /admin/forgot-password          → showAdminForgotPassword
POST /admin/forgot-password          → storeAdminForgotPassword
GET  /admin/reset-password/{token}   → showAdminResetPassword
POST /admin/reset-password           → storeAdminResetPassword
```

### Protected Routes

```
POST /logout                         → logout (middleware: auth)
GET  /user/dashboard                 → (middleware: auth, is.user)
GET  /user/*                         → (middleware: auth, is.user)
GET  /admin/dashboard                → (middleware: auth, is.admin)
GET  /admin/*                        → (middleware: auth, is.admin)
```

---

## 🔐 Middleware Aliases

Di `bootstrap/app.php` didaftarkan:

```php
'is.admin'  => \App\Http\Middleware\IsAdmin::class,
'is.user'   => \App\Http\Middleware\IsUser::class,
'is.guest'  => \App\Http\Middleware\IsGuest::class,
```

---

## 📊 Database

### Table: `password_reset_tokens`

Sudah ada di migration 0001_01_01_000000_create_users_table.php

```sql
Schema::create('password_reset_tokens', function (Blueprint $table) {
    $table->string('email')->primary();
    $table->string('token');
    $table->timestamp('created_at')->nullable();
});
```

### User Model

Model sudah support dengan field:

- `name` - Nama lengkap
- `username` - Username unik
- `email` - Email unik
- `password` - Password (di-hash otomatis)
- `role` - Enum: ['ipb', 'umum', 'admin']

---

## 🎨 Design Pattern

### Template Consistency

Semua views menggunakan:

- **Framework**: Tailwind CSS
- **Font**: Plus Jakarta Sans
- **Color Scheme**: Gradient backgrounds dengan emojis
    - User (Green): Untuk user login/register
    - Blue: Untuk admin login
    - Amber/Red: Untuk forgot password
    - Indigo: Untuk reset password admin

### Error Handling

- Validasi di controller dengan custom messages (bahasa Indonesia)
- Menampilkan error di view menggunakan `$errors->all()`
- Flash messages untuk sukses (`session('success')`)

### Security

- Password di-hash menggunakan Laravel's `Hash::make()`
- Token reset password dengan expires time default (Laravel: 1 jam)
- Role-based access control melalui middleware
- CSRF protection dengan `@csrf` di semua forms

---

## 📝 Cara Menggunakan

### Untuk User

#### 1. Register

```
GET  /register       → Tampilkan form
POST /register       → Submit form (name, username, email, password, password_confirmation)
```

- Auto-login setelah sukses
- Redirect ke `/user/dashboard`

#### 2. Login

```
GET  /login          → Tampilkan form
POST /login          → Submit form (login: username/email, password, remember)
```

- Redirect ke `/user/dashboard`

#### 3. Forgot Password

```
GET  /forgot-password → Tampilkan form
POST /forgot-password → Submit email
```

- Email dikirim dengan link reset password
- Link valid 1 jam

#### 4. Reset Password

```
GET  /reset-password/{token}  → Tampilkan form
POST /reset-password          → Submit form (email, password, password_confirmation, token)
```

- Redirect ke `/login` setelah sukses

### Untuk Admin

#### 1. Login

```
GET  /admin/login     → Tampilkan form
POST /admin/login     → Submit form (login: username/email, password, remember)
```

- Validasi: role HARUS 'admin'
- Redirect ke `/admin/dashboard`

#### 2. Forgot Password

```
GET  /admin/forgot-password → Tampilkan form
POST /admin/forgot-password → Submit email
```

- Email dikirim dengan link reset password
- Validasi: email HARUS terdaftar sebagai admin

#### 3. Reset Password

```
GET  /admin/reset-password/{token}  → Tampilkan form
POST /admin/reset-password          → Submit form
```

- Redirect ke `/admin/login` setelah sukses

### Logout

```
POST /logout → Logout (csrf token required)
```

---

## ⚙️ Konfigurasi Email (Optional)

Untuk mengirim email reset password, update `.env`:

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

Atau gunakan driver lokal untuk testing:

```env
MAIL_MAILER=log
```

---

## 🔄 Alur Autentikasi

### User Registration Flow

```
1. User ke /register
2. Lihat form registrasi
3. Isi name, username, email, password
4. Submit form (POST /register)
5. Validasi di controller
6. Buat user dengan role='umum'
7. Auto-login
8. Redirect ke /user/dashboard
```

### Admin Login Flow

```
1. Admin ke /admin/login
2. Lihat form login
3. Isi username/email & password
4. Submit form (POST /admin/login)
5. Validasi di controller (role='admin' required)
6. Create session
7. Redirect ke /admin/dashboard
```

### Reset Password Flow

```
1. User ke /forgot-password
2. Input email
3. Submit (POST /forgot-password)
4. Email sent dengan link reset: /reset-password/{token}
5. User klik link di email
6. Lihat form reset password
7. Input password baru
8. Submit (POST /reset-password)
9. Validasi token & update password
10. Redirect ke /login atau /admin/login
```

---

## 🚀 Testing

### Manual Testing Checklist

- [ ] User dapat register dengan data valid
- [ ] User tidak bisa register dengan username/email yang sudah ada
- [ ] User dapat login dengan username
- [ ] User dapat login dengan email
- [ ] User dapat logout
- [ ] User dapat request reset password
- [ ] Link reset password valid 1 jam
- [ ] User dapat reset password
- [ ] Admin dapat login (hanya role='admin')
- [ ] User (non-admin) tidak bisa akses `/admin/*`
- [ ] Non-login user tidak bisa akses `/user/*` atau `/admin/*`
- [ ] Password di-hash (tidak tersimpan plain text)

---

## 📚 Struktur File

```
app/
├── Http/
│   ├── Controllers/
│   │   └── SessionAuthController.php ✨ NEW
│   └── Middleware/
│       ├── IsAdmin.php ✨ NEW
│       ├── IsUser.php ✨ NEW
│       └── IsGuest.php ✨ NEW
│
bootstrap/
└── app.php (updated with middleware aliases)

resources/
└── views/
    ├── auth/
    │   ├── login.blade.php ✨ NEW
    │   ├── register.blade.php ✨ NEW
    │   ├── forgot-password.blade.php ✨ NEW
    │   └── reset-password.blade.php ✨ NEW
    └── admin/
        ├── login-admin.blade.php ✨ NEW
        ├── lupapwadmin_session.blade.php ✨ NEW
        └── reset-password-admin.blade.php ✨ NEW

routes/
└── web.php (updated with auth routes & middleware)
```

---

## 💡 Tips Customization

### Mengubah Expiry Time Token Reset Password

Edit di `.env`:

```env
PASSWORD_RESET_TIMEOUT=3600  # Default 1 jam, ubah sesuai kebutuhan (dalam detik)
```

### Mengubah Role User Default

Di `SessionAuthController.php`, method `storeUserRegister()`:

```php
'role' => 'umum',  // Ubah ke role lain jika diperlukan
```

### Mengubah Redirect Setelah Login

Di `SessionAuthController.php`, method `storeUserLogin()` dan `storeAdminLogin()`:

```php
return redirect()->route('user.dashboard');  // Ubah route sesuai kebutuhan
```

### Mengubah Validasi Error Messages

Semua custom messages sudah di-set di controller. Edit di method masing-masing.

### Mengubah Template Design

Semua views menggunakan Tailwind CSS, mudah di-customize. Edit `resources/views/auth/*` dan `resources/views/admin/*.blade.php`

---

## ✅ Fitur yang Sudah Terimplementasi

✅ User Registration dengan validasi
✅ User Login (username/email)
✅ User Forgot & Reset Password
✅ Admin Login (role-based)
✅ Admin Forgot & Reset Password
✅ Session-based Authentication
✅ Middleware for role-based access
✅ Password hashing
✅ CSRF protection
✅ Error handling & validation
✅ Flash messages
✅ Consistent UI design
✅ Bahasa Indonesia support
✅ Remember me functionality
✅ Logout functionality

---

## 🎯 Next Steps (Optional)

Jika ingin enhancement lebih lanjut:

1. Email verification untuk user baru
2. Two-factor authentication (2FA) untuk admin
3. Login history & activity log
4. Password strength meter
5. Social login (Google, GitHub)
6. Captcha untuk login & register
7. API-based auth (jika perlu)
8. User profile & settings page
9. Account deactivation
10. Admin user management

---

**Created**: 2026-06-02  
**Version**: 1.0  
**Status**: Production Ready ✨
