# 🏛️ Vacancy Management System

> A dynamic, full-featured vacancy lifecycle management system for Government and Non-Government organizations in Nepal — built with **Laravel 8**, **PHP 7.4**, and **Rudbooster**.

![Laravel](https://img.shields.io/badge/Laravel-8.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-7.4-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-Proprietary-red?style=for-the-badge)
![Status](https://img.shields.io/badge/Status-Production-brightgreen?style=for-the-badge)

---

## 📌 Overview

The **Vacancy Management System** is a comprehensive web application that manages the complete vacancy lifecycle — from job posting to final selection — for both government and non-government organizations. It has been deployed in production at **Nepal Telecom (NTC)** and various other government institutions in Nepal.

The system is fully dynamic, meaning organizations can configure their own vacancy rules, quota categories, exam phases, and promotion criteria without code changes.

---

## ✨ Features

### 📋 Vacancy Management
- Create and manage vacancies for govt and non-govt organizations
- Define post levels, departments, and required qualifications
- Configure quota categories: Open, Women, Inclusive, Indigenous, Madhesi, Disabled, Backward

### 📝 Online Application
- Applicant registration and login portal
- Dynamic application form per vacancy
- Document uploads (citizenship, certificates, photo)
- Application fee tracking and payment status

### 📅 Exam Management
- Schedule written, practical, and oral examinations
- Assign exam venues and roll numbers
- Manage multiple exam phases (Preliminary, Written, Interview)
- Mark attendance and upload marks per phase

### 🪪 Admit Card System
- Auto-generate admit cards with roll number, photo, exam date/time, venue
- Status tracking: Pending → Approved → Downloaded
- Bulk admit card generation
- Printable PDF output

### 📊 Result Processing
- Merit list generation by category and quota
- Configurable pass marks per exam phase
- Auto-disqualification on absent/fail
- Final merit ranking and selection list generation

### 📁 File Promotion Calculation
- Automatic promotion calculation based on marks, service period, seniority, and defined organizational rules
- Supports multiple promotion criteria
- Generates printable promotion order documents

### 📤 Reports & Export
- Export applicant lists, exam results, merit lists, and selection orders to PDF and Excel
- Dashboard statistics and vacancy summaries
- Audit logs and activity history

### 🏢 Multi-Organization Support
- Multiple organizations under one installation
- Each organization manages its own vacancies, exams, and results independently

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 8 (PHP 7.4) |
| Admin Panel | [Rudbooster](https://rudbooster.com) |
| Database | MySQL 5.7+ / MariaDB 10.3+ |
| Frontend | Blade Templates, Bootstrap, jQuery |
| Auth | Laravel Auth + Role-Based Access Control |
| PDF Generation | DomPDF / Snappy (wkhtmltopdf) |
| File Storage | Laravel Storage / Intervention Image |
| Server | Apache / Nginx on Linux |

---

## ⚙️ Requirements

- PHP >= 7.4
- Composer >= 2.x
- MySQL >= 5.7 or MariaDB >= 10.3
- Node.js >= 14.x & NPM
- Apache or Nginx

**Required PHP Extensions:** BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

---

## 🚀 Installation

### 1. Clone the repository
```bash
git clone https://github.com/yourorg/vacancy-management-system.git
cd vacancy-management-system
```

### 2. Install PHP dependencies
```bash
composer install
```

### 3. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```
Update `.env` with your database, mail, and app settings.

### 4. Run migrations and seeders
```bash
php artisan migrate --seed
```

### 5. Publish Rudbooster assets
```bash
php artisan vendor:publish --provider="crocodicstudio\rconfig\ServiceProvider"
npm install && npm run dev
```

### 6. Storage link and permissions
```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

### 7. Serve the application
```bash
php artisan serve
```
Visit `http://localhost:8000/admin` for the admin panel.

---

## 🔄 System Workflow

```
Vacancy Published
      ↓
Applicants Apply Online
      ↓
Applications Reviewed & Verified
      ↓
Admit Cards Generated & Distributed
      ↓
Exam Conducted → Marks Uploaded
      ↓
Merit List Generated (per quota)
      ↓
Final Selection List Published
      ↓
Promotion Files Calculated & Forwarded
```

---

## 🔐 Security

- CSRF protection on all forms
- Role-based access control (Applicant / Operator / Super Admin)
- Input validation and sanitization on all endpoints
- File upload restrictions (type & size)
- Rate limiting on login and form submission
- All sensitive config stored in environment variables

---

## 🏗️ Admin Panel — Rudbooster

This system uses **[Rudbooster](https://rudbooster.com)**, a Laravel admin scaffolding package, which provides:

- Visual CRUD builder
- Role & permission management
- Dynamic menus and navigation
- File manager for uploads
- System settings (SMS gateway, email, org info)
- Dashboard widgets and charts

---

## 🌐 Deployment — Production

```bash
# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Queue worker for background jobs
php artisan queue:work

# Cron for scheduled tasks
* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
```

Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`.

---

## 🏢 Used By

| Organization | Sector |
|---|---|
| **Nepal Telecom (NTC)** | Government Telecom |
| Various Government Ministries | Public Sector |
| Non-Government Organizations | Private Sector |

---

## 📁 Project Structure

```
vacancy-management-system/
├── app/
│   ├── Http/Controllers/       # Application controllers
│   ├── Models/                 # Eloquent models
│   └── Services/               # Business logic (promotion, merit list)
├── database/
│   ├── migrations/             # DB schema
│   └── seeders/                # Default data
├── resources/
│   ├── views/                  # Blade templates
│   └── lang/                   # Localization (English/Nepali)
├── routes/
│   ├── web.php                 # Web routes
│   └── api.php                 # API routes
└── public/                     # Web root
```

---

## 📄 License

This is proprietary software developed for institutional use in Nepal. Unauthorized copying, redistribution, or deployment outside licensed organizations is strictly prohibited.

For licensing inquiries, contact the development team.

---

## 🤝 Contributing

This is a closed-source institutional project. For bug reports or feature requests from authorized organizations, please contact the maintainer directly.

---

*Built with ❤️ using Laravel 8 + Rudbooster — Trusted by Nepal Telecom*
