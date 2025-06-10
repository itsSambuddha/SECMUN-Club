# 📘 The SECMUN Club Website

**The SECMUN Club Website** is a dynamic, PHP-based web application designed for managing and showcasing the activities, achievements, and structure of the SECMUN Club. The system supports user registrations, administrator hierarchies, content display, and modular site navigation with secure authentication.

---

## 🌐 Overview

The website is designed for:

* Club members to view content
* Core committee/admins to log in and post updates
* Top admins (e.g., President, Secretary) to approve admins and control access

This site includes responsive layout (only for PC as of now), role-based login system, basic CRUD functionalities, and a database-integrated backend.

---

## 💠 Tech Stack

* **Frontend**: HTML, CSS
* **Backend**: PHP (Procedural)
* **Database**: MySQL
* **Styling**: Custom CSS (`style.css`)
* **Session Handling**: PHP `$_SESSION`

---

## 🗃️ Directory Structure

```
THE SECMUN CLUB WEBSITE/
├── assets/
│   ├── auth.php
│   └── style.css
├── about.php
├── achievements.php
├── db_connect.php
├── footer.php
├── functions.php
├── gazette.php
├── header.php
├── index.php
├── login_signup.php
├── logout.php
├── SECMUN.sql
└── README.md
```

---

## 📂 File Descriptions

### 🔐 `auth.php`

* Handles session-based access control
* Redirects unauthenticated users
* Used in pages where login is required

### 🎨 `style.css`

* Contains all site styles
* Responsive layout, forms, buttons, text formatting
* Shared across all pages

### 📂 `db_connect.php`

* Establishes MySQL connection via `mysqli` or `PDO`
* Required for all DB-related operations

### 🧠 `functions.php`

* Houses utility functions for:

  * Registering users/admins
  * Logging in users
  * Role and approval verification

### 🏠 `index.php`

* Homepage
* Introductory content about the club

### 🧾 `about.php`

* Static info about club vision, mission, team, etc.

### 🏆 `achievements.php`

* Displays club achievements
* Can be static or DB-driven

### 📰 `gazette.php`

* Displays club publications or event summaries
* (Optional: download links for PDFs)

### 🔐 `login_signup.php`

* Handles both login and registration
* Role toggle between `user` and `admin`
* Dynamic feedback and validations

### 🚪 `logout.php`

* Destroys session and logs out user/admin

### 🧱 `SECMUN.sql`

* Database schema dump
* Contains table(s):

  * `users`: stores name, email, password (hashed), role, approval status, post

---

## 🔑 Authentication & Roles

| Role      | Access                     | Permissions                              |
| --------- | -------------------------- | ---------------------------------------- |
| Guest     | Public pages               | View only                                |
| User      | Logged-in club member      | View role-specific data                  |
| Admin     | Mid-level core committee   | Submit posts (pending approval)          |
| Top Admin | President, Secretary, etc. | Approve/reject admins, full site control |

---

## 🧪 Features

* ✅ Secure login/signup with hashed passwords
* ✅ Role-based dynamic content rendering
* ✅ Admin approval system
* ✅ Mobile-responsive layout
* ✅ Modular architecture via `header.php`, `footer.php`, `functions.php`
* ✅ Easy database import via `SECMUN.sql`

---

## 🧰 Installation & Setup

1. **Clone the repo**

   ```bash
   git clone <repo_url>
   cd secmun-website
   ```

2. **Import the SQL file**

   * Go to phpMyAdmin
   * Create a new database (e.g. `secmun`)
   * Import `SECMUN.sql`

3. **Configure DB connection**
   Edit `db_connect.php`:

   ```php
   $conn = mysqli_connect("localhost", "root", "", "secmun");
   ```

4. **Launch**

   * Place project in your local server directory (`htdocs` if using XAMPP)
   * Run `localhost/secmun-website/index.php`
  
5. **Use the website**

    *https://thesecmunclub.infinityfreeapp.com/*
---

## 🔮 Future Features (Suggested)

* Event calendar
* Post moderation by Top Admins
* Comment system for gazette
* Email notification on approval
* Admin dashboard UI

---

## 👨‍💻 Credits

Developed by:
* **Sambuddha Das**
* *Secretary General of the SECMUN Club*
* Department of Computer Science
* St. Edmund's College

---

## 📜 License

This project is under MIT License. Use it freely for educational and club-related purposes.
*I copied this from ChatGPT hehehe*

---
