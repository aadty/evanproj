# 🗺️ Authentication System Architecture & Flow

## System Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                         Web Application                          │
│                                                                   │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │                    Routes (web.php)                      │   │
│  │  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐     │   │
│  │  │  Home (/)   │  │  Auth Routs │  │  Dashboard  │     │   │
│  │  │  Public     │  │  (guest MW) │  │  (auth MW)  │     │   │
│  │  └─────────────┘  └─────────────┘  └─────────────┘     │   │
│  └──────────────────────────────────────────────────────────┘   │
│                              ↓                                    │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │                      Controllers                         │   │
│  │                                                           │   │
│  │  ┌──────────────────────┐  ┌──────────────────────┐     │   │
│  │  │   AuthController     │  │ DashboardController  │     │   │
│  │  │                      │  │                      │     │   │
│  │  │ • showRegister()     │  │ • index()            │     │   │
│  │  │ • register()         │  │                      │     │   │
│  │  │ • showLogin()        │  │ Shows user dashboard │     │   │
│  │  │ • login()            │  │                      │     │   │
│  │  │ • logout()           │  │ Protected by 'auth'  │     │   │
│  │  │                      │  │                      │     │   │
│  │  │ All validation       │  └──────────────────────┘     │   │
│  │  │ & hashing here       │                                │   │
│  │  └──────────────────────┘                                │   │
│  └──────────────────────────────────────────────────────────┘   │
│                              ↓                                    │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │                        Models                            │   │
│  │                    (app/Models)                          │   │
│  │                                                           │   │
│  │  ┌──────────────────────────────────────────────────┐   │   │
│  │  │              User Model                          │   │   │
│  │  │  • Authenticatable (session auth support)       │   │   │
│  │  │  • Fields: id, name, email, password            │   │   │
│  │  │  • Mass assignable: name, email, password       │   │   │
│  │  └──────────────────────────────────────────────────┘   │   │
│  └──────────────────────────────────────────────────────────┘   │
│                              ↓                                    │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │                      Database                            │   │
│  │              (MySQL - users table)                       │   │
│  │                                                           │   │
│  │  ┌──────────────────────────────────────────────────┐   │   │
│  │  │ id │ name  │ email    │ password   │ timestamps │   │   │
│  │  ├────┼───────┼──────────┼────────────┼────────────┤   │   │
│  │  │ 1  │ John  │ j@ex.com │ $2y$10... │ 2025-...   │   │   │
│  │  │ 2  │ Jane  │ j@ex.com │ $2y$10... │ 2025-...   │   │   │
│  │  └──────────────────────────────────────────────────┘   │   │
│  └──────────────────────────────────────────────────────────┘   │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
```

---

## User Registration Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                     REGISTRATION FLOW                            │
└─────────────────────────────────────────────────────────────────┘

1. USER VISITS /register
   ↓
   GET /register
   ├─ Middleware: guest (not logged in)
   └─ AuthController@showRegister()
      └─ Returns: resources/views/auth/register.blade.php

2. USER FILLS FORM & SUBMITS
   ↓
   Input:
   ├─ name: "John Doe"
   ├─ email: "john@example.com"
   ├─ password: "secret123"
   └─ password_confirmation: "secret123"

3. POST REQUEST TO /register
   ↓
   POST /register
   ├─ Middleware: guest (not logged in)
   └─ AuthController@register($request)

4. VALIDATION
   ↓
   $request->validate([
       'name' => 'required|string|max:255',
       'email' => 'required|email|unique:users,email',
       'password' => 'required|string|min:6|confirmed'
   ])
   
   ✓ If valid → Continue to step 5
   ✗ If invalid → Back to form with errors

5. PASSWORD HASHING & USER CREATION
   ↓
   User::create([
       'name' => $validated['name'],
       'email' => $validated['email'],
       'password' => Hash::make($validated['password'])
                    // Converts "secret123" to "$2y$10$..."
   ])

6. AUTO-LOGIN
   ↓
   Auth::login($user)
   
   Session is created:
   ├─ user_id stored in session
   ├─ Session cookie sent to browser
   └─ User is now authenticated

7. REDIRECT TO DASHBOARD
   ↓
   redirect('/dashboard')->with('success', 'Registration successful!')
   
   Browser receives:
   ├─ 302 Redirect response
   ├─ Location: /dashboard
   └─ Flash message in session

8. DASHBOARD PAGE LOADS
   ↓
   GET /dashboard
   ├─ Middleware: auth (user logged in) ✓
   └─ DashboardController@index()
      └─ Returns dashboard with user info

┌─────────────────────────────────────────────────────────────────┐
│                    END RESULT                                    │
│  User registered, logged in, viewing dashboard                  │
│  Session cookie stored in browser                               │
│  Password securely hashed in database                            │
└─────────────────────────────────────────────────────────────────┘
```

---

## User Login Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                        LOGIN FLOW                                │
└─────────────────────────────────────────────────────────────────┘

1. USER VISITS /login
   ↓
   GET /login
   ├─ Middleware: guest (not logged in)
   └─ AuthController@showLogin()
      └─ Returns: resources/views/auth/login.blade.php

2. USER FILLS FORM & SUBMITS
   ↓
   Input:
   ├─ email: "john@example.com"
   └─ password: "secret123"

3. POST REQUEST TO /login
   ↓
   POST /login
   ├─ Middleware: guest (not logged in)
   └─ AuthController@login($request)

4. VALIDATION
   ↓
   $request->validate([
       'email' => 'required|email',
       'password' => 'required|string'
   ])
   
   ✓ If valid → Continue to step 5
   ✗ If invalid → Back with errors

5. AUTHENTICATION ATTEMPT
   ↓
   Auth::attempt($credentials)
   
   System:
   ├─ Finds user by email
   ├─ Uses Hash::check(input_password, db_password)
   │  └─ Compares "secret123" with "$2y$10$..."
   └─ Returns true/false

   ✓ Credentials valid → Step 6
   ✗ Credentials invalid → Step 6B

6. SUCCESS PATH
   ↓
   $request->session()->regenerate()
   (Creates new session ID for security)
   
   Session created:
   ├─ user_id = 1
   ├─ Session cookie sent
   └─ Old session destroyed
   
   redirect('/dashboard')->with('success', ...)
   └─ Browser redirected to dashboard

6B. FAILURE PATH
   ↓
   return back()
       ->withInput($request->only('email'))
       ->withErrors(['email' => 'Invalid credentials'])
   
   User sent back to login form:
   ├─ Email value retained
   ├─ Error message displayed
   └─ Password NOT retained (for security)

7. AUTHENTICATED STATE
   ↓
   User can now:
   ├─ Access /dashboard
   ├─ Access any route with 'auth' middleware
   └─ Use auth()->user() helper

┌─────────────────────────────────────────────────────────────────┐
│                    END RESULT                                    │
│  User authenticated via session                                  │
│  Session valid for duration of browser session                  │
│  Session data persists across page navigations                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## User Logout Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                       LOGOUT FLOW                                │
└─────────────────────────────────────────────────────────────────┘

1. USER ON DASHBOARD
   ↓
   User is logged in (session active)
   └─ auth()->user() returns User object

2. USER CLICKS LOGOUT BUTTON
   ↓
   <form action="{{ route('logout') }}" method="POST">
       @csrf
       <button type="submit">Logout</button>
   </form>

3. POST REQUEST TO /logout
   ↓
   POST /logout
   ├─ Middleware: auth (user must be logged in) ✓
   └─ AuthController@logout($request)

4. SESSION CLEANUP
   ↓
   Auth::logout()
   ├─ Removes user from session
   └─ auth()->user() now returns null
   
   $request->session()->invalidate()
   ├─ Destroys entire session
   ├─ Session data cleared from storage
   └─ Cannot be used again

5. CSRF TOKEN REGENERATION
   ↓
   $request->session()->regenerateToken()
   ├─ Old CSRF token deleted
   ├─ New CSRF token generated
   └─ Prevents token reuse attacks

6. REDIRECT TO HOME
   ↓
   redirect('/')->with('success', 'Logged out successfully!')
   
   Browser receives:
   ├─ 302 Redirect response
   ├─ Location: /
   ├─ Session cookie cleared/expired
   └─ Flash message in new session

7. UNAUTHENTICATED STATE
   ↓
   User cannot:
   ├─ Access /dashboard (redirected to /login)
   ├─ Use auth()->user() (returns null)
   └─ Access routes with 'auth' middleware

┌─────────────────────────────────────────────────────────────────┐
│                    END RESULT                                    │
│  User fully logged out                                           │
│  Session destroyed                                               │
│  Browser cookies cleared                                         │
│  Cannot access protected routes                                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## Middleware Protection

```
┌─────────────────────────────────────────────────────────────────┐
│            MIDDLEWARE FLOW - 'guest' Middleware                 │
└─────────────────────────────────────────────────────────────────┘

Protects: /register, /login (GET & POST)
Purpose: Prevent logged-in users from accessing these routes

Request comes in
    ↓
Check: Is user already logged in?
    ↓
    ├─ YES (auth()->check() = true)
    │  └─ Redirect to /dashboard
    │     (Config: redirect guard -> usually /home or /dashboard)
    │
    └─ NO (auth()->check() = false)
       └─ Continue to controller


┌─────────────────────────────────────────────────────────────────┐
│            MIDDLEWARE FLOW - 'auth' Middleware                  │
└─────────────────────────────────────────────────────────────────┘

Protects: /dashboard, /logout (GET & POST)
Purpose: Ensure only logged-in users can access

Request comes in
    ↓
Check: Is user logged in?
    ↓
    ├─ YES (auth()->check() = true)
    │  └─ Continue to controller
    │
    └─ NO (auth()->check() = false)
       └─ Redirect to /login
          (Unauthenticated requests sent to login)
```

---

## Session & Authentication Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                 SESSION & AUTHENTICATION                         │
└─────────────────────────────────────────────────────────────────┘

BROWSER                          SERVER
───────                          ──────

                    1. Login Request
         POST /login (email, password)
         ─────────────────────────────→
                                    Verify credentials
                                    Create session (ID: abc123)
                                    Store: sessions table
                                    ├─ id: abc123
                                    ├─ user_id: 1
                                    ├─ ip: 192.168.1.1
                                    ├─ user_agent: Chrome...
                                    └─ payload: user_id=1

         ←─────────────────────────────
    Set-Cookie: LARAVEL_SESSION=abc123
    Redirect to /dashboard

Store cookie                    2. Authenticated Request
in browser            GET /dashboard
         ─────────────────────────────→
         Cookie: LARAVEL_SESSION=abc123
                                    Look up session abc123
                                    Find user_id: 1
                                    Load User (id=1)
                                    auth()->user() = User object

         ←─────────────────────────────
         Display dashboard

                    3. Subsequent Requests
         GET /api/user/profile
         Cookie: LARAVEL_SESSION=abc123
         ─────────────────────────────→
                                    Session valid?
                                    ├─ YES: Retrieve user
                                    └─ NO: Redirect to /login

         ←─────────────────────────────
         Send user data

                    4. Logout
         POST /logout
         Cookie: LARAVEL_SESSION=abc123
         ─────────────────────────────→
                                    Find session abc123
                                    Delete session
                                    Clear from database

         ←─────────────────────────────
    Set-Cookie: (expire immediately)
    Redirect to /

Clear cookie                    5. Next Request
in browser            GET /dashboard
         ─────────────────────────────→
         (No valid session cookie)
                                    No session found
                                    auth()->check() = false
                                    Redirect to /login

         ←─────────────────────────────
         Redirect to /login
```

---

## Route Access Decision Tree

```
┌──────────────────────────────────────────────────────────┐
│        CAN USER ACCESS THIS ROUTE?                       │
└──────────────────────────────────────────────────────────┘

                    User makes request
                           ↓
                     Is auth check passed?
                     /
                    /
                   /
         YES /    \ NO
            /        \
           /          \
        /              \
    ✓ PASS           ✗ FAIL
    Continue to        Take action:
    controller      (depends on middleware)
    
Route: GET / (public)
├─ User: Any (authenticated or not)
├─ Middleware: None
└─ Result: Always accessible ✓

Route: GET /register (guest-only)
├─ User: Not logged in
│  └─ Middleware: guest
│     └─ Result: Accessible ✓
│
├─ User: Logged in
│  └─ Middleware: guest
│     └─ Result: Redirected to /dashboard ✗

Route: GET /login (guest-only)
├─ User: Not logged in
│  └─ Middleware: guest
│     └─ Result: Accessible ✓
│
├─ User: Logged in
│  └─ Middleware: guest
│     └─ Result: Redirected to /dashboard ✗

Route: GET /dashboard (auth-only)
├─ User: Logged in
│  └─ Middleware: auth
│     └─ Result: Accessible ✓
│
├─ User: Not logged in
│  └─ Middleware: auth
│     └─ Result: Redirected to /login ✗

Route: POST /logout (auth-only)
├─ User: Logged in
│  └─ Middleware: auth
│     └─ Result: Accessible ✓
│
├─ User: Not logged in
│  └─ Middleware: auth
│     └─ Result: Redirected to /login ✗
```

---

## Password Hashing & Verification

```
┌─────────────────────────────────────────────────────────────────┐
│            PASSWORD HASHING & VERIFICATION                      │
└─────────────────────────────────────────────────────────────────┘

REGISTRATION - HASHING
──────────────────────

User enters password: "MySecurePassword123"
                ↓
    Hash::make("MySecurePassword123")
                ↓
         Uses bcrypt algorithm
         with salt and rounds
                ↓
    $2y$10$abc...xyz (64 chars)
                ↓
    Stored in database (never store plaintext!)

Database entry:
│ email         │ password              │
├───────────────┼──────────────────────┤
│ john@ex.com   │ $2y$10$abc...xyz     │


LOGIN - VERIFICATION
────────────────────

User enters password: "MySecurePassword123"
                ↓
    Auth::attempt(['email' => ..., 'password' => ...])
                ↓
    Find user by email
    Get stored hash: $2y$10$abc...xyz
                ↓
    Hash::check("MySecurePassword123", "$2y$10$abc...xyz")
                ↓
    Uses bcrypt to check if password matches hash
                ↓
    Returns TRUE or FALSE
                ↓
    If TRUE:  Create session, login user
    If FALSE: Show error message


WHY BCRYPT?
───────────

✓ One-way hashing (cannot be reversed)
✓ Salted (random data added before hashing)
✓ Slow (resistant to brute force)
✓ Adaptive (can increase rounds as computers get faster)
✓ Industry standard (used everywhere)

Example: Same password, different hashes (different salts)
"password" → $2y$10$A8N5Yzuw5...
"password" → $2y$10$N9P6Tjvxb...
"password" → $2y$10$B7C8Uvlwc...
```

---

## Database Schema Relationship

```
┌────────────────────────────────────────────┐
│           users TABLE                      │
├────────────────────────────────────────────┤
│                                            │
│  id (PRIMARY KEY)                          │
│  ├─ Auto-incrementing integer              │
│  └─ Uniquely identifies each user          │
│                                            │
│  name (VARCHAR 255)                        │
│  ├─ User's display name                    │
│  └─ Required, can be non-unique            │
│                                            │
│  email (VARCHAR 255)                       │
│  ├─ User's email address                   │
│  ├─ Required                               │
│  ├─ UNIQUE constraint                      │
│  └─ No duplicate emails allowed            │
│                                            │
│  email_verified_at (TIMESTAMP, nullable)   │
│  ├─ When user verified email               │
│  ├─ NULL if not verified                   │
│  └─ Not used in this simple system         │
│                                            │
│  password (VARCHAR 255)                    │
│  ├─ Bcrypt hashed password                 │
│  ├─ Never store plaintext                  │
│  └─ Always use Hash::make()                │
│                                            │
│  remember_token (VARCHAR 100)              │
│  ├─ For "Remember Me" functionality        │
│  └─ NULL for now                           │
│                                            │
│  created_at (TIMESTAMP)                    │
│  ├─ When user was created                  │
│  └─ Auto-set by Laravel                    │
│                                            │
│  updated_at (TIMESTAMP)                    │
│  ├─ When user was last updated             │
│  └─ Auto-updated by Laravel                │
│                                            │
└────────────────────────────────────────────┘
```

---

**Generated**: December 3, 2025 | **Framework**: Laravel 11+ | **Status**: ✅ Ready
