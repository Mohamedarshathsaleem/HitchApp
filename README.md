# 🚗 HitchApp — Campus Ride-Sharing Web App

[![PHP lint](https://github.com/Mohamedarshathsaleem/HitchApp/actions/workflows/lint.yml/badge.svg)](https://github.com/Mohamedarshathsaleem/HitchApp/actions/workflows/lint.yml)
![PHP](https://img.shields.io/badge/PHP-8-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8-4479A1?logo=mysql&logoColor=white)

**A ride-sharing web app where students publish trips, search by route and book or cancel seats. It was my first full-stack project (Web Programming, UTM, 2024).**

<!-- Add a screenshot here, e.g. docs/home.png -->
<!-- ![HitchApp home](docs/home.png) -->

📄 [Project report](https://github.com/user-attachments/files/16539864/HitchApp_Report_CodeBois.pdf) · 📘 [User manual](https://github.com/user-attachments/files/16539865/USER.MANUAL_HitchApp.pdf)

---

## ✨ Features

- **Accounts.** Register, log in, edit your profile and log out (PHP sessions).
- **Publish rides.** Drivers post a trip with route, date/time and available seats.
- **Search and sort.** Find rides by start and end location, sorted by departure time or seats left.
- **Book and cancel.** Booking decrements available seats; cancelling restores them.
- **My Activity.** One page listing the rides you've published and the rides you've booked.

## 🛠️ Tech stack

PHP 8 (mysqli, sessions) · MySQL · HTML5 · CSS3 · vanilla JavaScript

## 🔐 Security fixes (2026 revisit)

I came back to this project after working on application security, audited it and fixed what I found:

| Issue | Fix |
|---|---|
| **SQL injection** in login, registration, profile edit and the search `ORDER BY` | Prepared statements with `bind_param`; an allow-list for the sort column |
| **Plain-text passwords** in the database | `password_hash` / `password_verify` (bcrypt) |
| **Password echoed back** into the profile form | Removed the field |
| **Stored XSS** via profile fields | `htmlspecialchars` on output |
| **Session fixation** | `session_regenerate_id(true)` after login |
| **Redirects without `exit`**, so protected pages kept running | `exit` after every `Location` header |
| **Real classmates' accounts** in the SQL dump | Replaced with demo accounts using hashed passwords |

A CI check now fails the build if anyone reintroduces string-built SQL.

## 🚀 Running locally

**Prerequisites:** PHP 8+ with mysqli, and MySQL/MariaDB (XAMPP works).

```bash
git clone https://github.com/Mohamedarshathsaleem/HitchApp.git
cd HitchApp/HitchAppa

mysql -u root -p -e "CREATE DATABASE user_info"
mysql -u root -p user_info < user_info.sql

# optional: DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE override the defaults in php/config.php
php -S localhost:8000
```

Open http://localhost:8000 and log in as `driver@example.com` or `rider@example.com` (password `demo-pass-123`).

## 👤 My role

<!-- TODO(Arshath): replace with exactly what you built; recruiters will ask. -->
This was a team project (group *CodeBois*). I worked on **[your parts: e.g. authentication, ride search, booking logic, database schema]** and later did the 2026 security hardening described above.

## 🧭 What I'd do differently now

- Use a framework (Laravel) with migrations, CSRF protection and validation built in
- Wrap booking in a database transaction so two people can't take the last seat at the same time
- Add automated feature tests and a live demo on a free host

## 📄 License

[MIT](LICENSE)
