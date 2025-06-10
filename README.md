# 📘 The SECMUN Club Website

**The SECMUN Club Website** is a dynamic, PHP-based web application designed for managing and showcasing the activities, achievements, and structure of the SECMUN Club. The system supports user registrations, administrator hierarchies, content display, and modular site navigation with secure authentication. It features a public-facing website and multiple dashboards (admin -top admin, mid admin and user) with role-based access control. Additionally, it supports event listings, contact forms, achievement displays, gazette publishing, and a dedicated section for MUN learning resources.

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
/ (root)
│
├── .github/workflows/
│   └── jekyll-gh-pages.yml
│
├── uploads/ppts/
│
├── SEC MUN.sql
├── README.md
│
├── auth.php
├── db_connect.php
├── functions.php
├── logout.php
│
├── login_signup.php
├── dashboard_user.php
├── dashboard_topadmin.php
├── dashboard_midadmin.php
│
├── header.php
├── footer.php
├── index.php
├── about.php
├── achievements.php
├── contact.php
├── event.php
├── gazette.php
├── delegate_allotment.php
├── learn_mun.php
├── index_sidebar.php
│
├── style.css
├── sidebar_style.css
├── progressbar.css
│
├── assets/
│   ├── instagram-icon.png
│   ├── whatsapp-icon-design.png
│   ├── secmuny.png
│   └── secretariat.png

```

---

## 📄 File Descriptions

1. **Core Files**

* **auth.php:** Handles login session validation and redirects unauthorized users.

* **db_connect.php:** Establishes a MySQL database connection for all pages.

* **functions.php:** Contains reusable PHP helper functions (e.g., redirect, sanitize input).

* **logout.php:** Terminates user sessions and redirects to the login/signup page.

2. **User Access & Dashboard**

* **login_signup.php:** Single page to handle both login and signup logic, storing user role.

* **dashboard_user.php:** Interface for regular users to see events, updates, and participation.

* **dashboard_topadmin.php:** Full-access admin panel for overseeing all modules.

* **dashboard_midadmin.php:** Mid-level dashboard with restricted access rights.

* **delegate_allotment.php:** Admin-only interface for assigning delegates to roles/events.

3. **Public Pages**

* **index.php:** Main landing page with general information and links.

* **about.php:** Overview of SEC MUN, its mission, and legacy.

* **achievements.php:** Highlights and showcases awards, recognitions, and milestones.

* **contact.php:** Contains a link to Instagram and WhatsApp links for reaching out to the club.

* **event.php:** Displays upcoming MUN events or conferences.

* **gazette.php:** Shows github project made by Mr. Vivian Alexandar Lyngdoh Noglait, which houses the club magazine(s) and the club newsletter(s).

* **learn_mun.php:** Educational content introducing MUN concepts and terminology.

4. **Layout Components**

* **header.php:** Shared header/navbar across all pages.

* **footer.php:** Shared footer across all pages.

* **index_sidebar.php:** Sidebar used within dashboard interfaces.

5. Stylesheets

* **style.css:** Primary CSS file managing layout, typography, and responsiveness.

* **sidebar_style.css:** Specific styles for the dashboard sidebars.

* **progressbar.css:** Styling for custom progress indicators.

6. **Assets**

* **secmuny.png:** Main logo for the club.

* **secretariat.png:** Image of the secretariat or club members.

* **instagram-icon.png:** Social media icon.

* **whatsapp-icon-design.png:** WhatsApp contact icon.

7. **Config & Deployment**

* **.github/workflows/jekyll-gh-pages.yml:** GitHub Actions workflow for CI/CD and GitHub Pages deployment.

---

## 🔑 Authentication & Roles

| Role      | Access                     | Permissions                              |
| --------- | -------------------------- | ---------------------------------------- |
| Guest     | Public pages               | View only                                |
| User      | Logged-in club member/USG Secretariat      | View role-specific data                  |
| Admin     | Mid-level core committee (Teacher I/C & Assistant Secretary General) | Submit posts (pending approval)          |
| Top Admin | President, Secretary, etc. | Approve/reject admins, full site control |

---

## 🧪 Features

🔐 Authentication: Secure login/signup with role-specific session handling

📊 Role-Based Dashboards: Dashboards for users, mid admins, and top admins

🧾 Delegate Management: Admin pages for keeping track of delegate allotments and MUN roles

📰 Gazette System: Linking to an external github link of a project made by Mr. Vivian Alexandar Lyngdoh Noglait 

📩 Contact Space: Capability to reach the club

🧠 Learn MUN: Dedicated section with resources for students new to MUNs

🏆 Achievements Display: Timeline/gallery-style display of club milestones and awards

📥 Document Upload: Presentation or document uploads (for admins)

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
* **Sambuddha Das** ( *your avg 'hated by all thus isolated' student* )
* *Secretary General of the SECMUN Club*
* Department of Computer Science
* St. Edmund's College
* *PS:-80% of this was coded at 3AM to distract myself from the crushing weight of existence, the floccinaucinihilipilification of my own life choices, and the deafening silence of a phone that only buzzes for OTPs. The rest? Offloaded to ChatGPT—my emotionally bankrupt AI intern who didn’t even pause when I ugly-cried into functions.php. This site is stitched together with duct tape, Maggi seasoning, cashews, Amul Choco Minis, and raw, unfiltered delusion. If it works, laugh like everything’s fine. If it doesn’t... well, it’s still 99.09% more stable than my mental health. So thanks to ChatGPT*

---

## 📜 License

This project is under MIT License. Use it freely for educational and club-related purposes.
* *I copied this Licence thing from ChatGPT hehehe*

---
