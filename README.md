# 🎓 TNTS ASPIRE

**ASPIRE** (Academic System for Portal, Information, Records & Enrollment) is a premium, web-based school management and portal system designed specifically for **Tanza National Trade School (TNTS)**. 

Built on a modern server-side reactive stack, ASPIRE centralizes pre-enrollments, student masterlists, sections, schedules, faculty profiles, and student portals into a cohesive, responsive experience.

---

## 🛠️ Tech Stack

*   **Backend**: [Laravel 11.x](https://laravel.com) (PHP 8.2+)
*   **Reactive Frontend**: [Livewire v3](https://livewire.laravel.com) & [Alpine.js](https://alpinejs.dev)
*   **Styling**: [Tailwind CSS v3](https://tailwindcss.com)
*   **Fonts & Icons**: Lexend font family & Google Material Symbols Outlined
*   **Build Tool**: [Vite](https://vitejs.dev)
*   **Database**: SQLite (local development) / MySQL (production-ready)

---

## ✨ System Features

### 1. Robust Admissions & Enrollment Workflow
*   **Multi-Step Application Wizard**: A public-facing form for new and returning students to submit enrollment data, select course preferences, and upload required documents (PSA Birth Certificate, SF9 Card, Good Moral, and 2x2 profile photos).
*   **LRN Duplicate Prevention**: Strict checks to intercept duplicate LRN entries at the drafting, submission, and admin approval phases to prevent double-enrollments.
*   **Automatic Account Provisioning**: Student portal accounts are automatically provisioned with a secure, formatted username (LRN) and temporary password upon admission approval.

### 2. Intelligent Student Masterlist & Sectioning
*   **Summary Statistics Dashboard**: Visual metrics at the top of the masterlist highlighting enrolled-to-applicant ratios per grade level (Grade 7 to Grade 12) with percentage bars.
*   **Grade Level Constraints (JHS TVL vs. SHS Normal)**:
    *   **Junior High TVL (Grades 8–10)** requires a `specialization` and sets `track`/`strand` to `null`.
    *   **Senior High (Grades 11–12)** requires a `track` (Academic or TechPro) and `strand`.
*   **Section Auto-clearing**: Upgrading a student's grade level automatically clears their current section assignments to prevent student-level mismatches.

### 3. Student Photo & Document Management
*   **Livewire Upload Previews**: Interactive upload widget inside the edit student modal allowing admins to update the student's 2x2 photo with real-time preview.
*   **Automated Disk Clean-up**: Automatically purges replaced or removed image files from the storage disk when changes are saved, avoiding orphaned files.
*   **User Avatar Synchronization**: Changes to a student's enrollment photo are instantly synchronized with their portal user account's avatar.

### 4. Learner's Formation Office (LFO) Violations Tracker
*   **Incident Logs**: Track and edit disciplinary violations categorized by severity levels (Low, Medium, High).
*   **Portal Notification**: Logged violations appear directly in the student's portal violations log.

### 5. Multi-format Exports
*   **ZIP Archive Package**: Exports student lists to CSV while packaging all corresponding student 2x2 photos renamed matching their full name.
*   **PDF/CSV Section Sheets**: Faculty can export handled section masterlists instantly.

---

## 🔒 Access Roles & Gates

The system defines authorization policies based on user roles:

| Role | Portal Access | Scope of Authority |
| :--- | :--- | :--- |
| **System Admin** | Admin Dashboard | Full CRUD over settings, school years, schedules, sections, admissions, and faculty. |
| **School Registrar** | Admin Dashboard | Manages student masterlist, reviews/approves admissions, and assigns academic sections. |
| **Learner's Formation (LFO)**| Admin Dashboard | Manages student violations, logs incidents, and checks masterlists. |
| **Guidance Counselor** | Admin Dashboard | Reads student masterlist, views profiles, and monitors violations. |
| **Faculty (Teacher)** | Faculty Portal | Views schedule, handles sections, and downloads student records (CSV/PDF). |
| **Student** | Student Portal | Views enrolment status, profile details (read-only), and violations log. |

---

## 🚀 Installation & Setup

Follow these steps to run the project locally:

### Prerequisites
Make sure you have **PHP 8.2+**, **Composer**, **Node.js (v18+)**, and **npm** installed on your system.

### 1. Clone & Install Dependencies
```bash
git clone https://github.com/Infinity-Solutions-PH/aspire-web.git
cd aspire-web
composer install
npm install
```

### 2. Configure Environment
```bash
cp .env.example .env
php artisan key:generate
```
Open `.env` and verify that the application parameters match your configuration.

### 3. Setup Database (SQLite)
Create an empty database file:
```bash
# On Linux/macOS
touch database/database.sqlite

# On Windows (PowerShell)
New-Item database/database.sqlite -ItemType File
```
Ensure your `.env` connection is configured for SQLite:
```env
DB_CONNECTION=sqlite
# DB_DATABASE=/absolute/path/to/database/database.sqlite
```

### 4. Database Migrations & Seeding
Run migrations along with default records (admin users, base rooms, subjects, and initial sections):
```bash
php artisan migrate:fresh --seed
```

### 5. Start Development Servers
Run the Laravel application server and Vite asset compiler simultaneously:
```bash
# Start Laravel application
php artisan serve

# In a separate terminal, start Vite
npm run dev
```

The system will be accessible on `http://127.0.0.1:8000`.

---

## 📂 Key Directories & Files

*   `app/Livewire/` - Contains the backend Livewire components handling views and state management.
    *   `Admin/StudentMasterlist.php` - Student data table, filters, and editor modal.
    *   `Admin/AdmissionReview.php` - Review dashboard for student pre-enrollment.
    *   `StudentPortal/Violations.php` - Student-facing disciplinary log page.
*   `resources/views/livewire/` - Blade templates housing frontend markup and styles.
    *   `admin/student-masterlist.blade.php` - Grid controls and modals.
    *   `student-portal/violations.blade.php` - Student violations list.
*   `resources/views/layouts/` - Root HTML templates:
    *   `app.blade.php` - System Administrator and Registrar layout.
    *   `student-portal.blade.php` - Student UI container.
    *   `faculty-portal.blade.php` - Faculty dashboard container.
*   `routes/` - Route registries:
    *   `admin.php` - Routes for administrators, registrars, and LFOs.
    *   `portal.php` - Routes for student and faculty portal logins.

---

## 📄 License

This system is intended for the internal academic and administrative operations of **Tanza National Trade School**. Distribution, replication, or modification without institutional authorization is strictly prohibited.
