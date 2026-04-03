# TNTS ASPIRE

**TNTS ASPIRE** (Academic System for Portal, Information, Records & Enrollment) is a web-based academic management system developed for **Tanza National Trade School (TNTS)**. The system centralizes student enrollment, grading, sectioning, and student portal access in a single, secure platform.

---

## ✨ Features

* 📋 **Enrollment Management** – Manage student registration and enrollment records
* 🎓 **Student Portal** – Students can view profiles, sections, and grades
* 🧮 **Grading System** – Encode, compute, and manage student grades
* 🏫 **Sectioning Management** – Assign students to sections efficiently
* 🔐 **Role-Based Access** – Admin, teacher, and student access levels
* 📱 **Responsive UI** – Works across desktop, tablet, and mobile devices

---

## 🛠 Tech Stack (VILT)

* **Vue.js** – Frontend framework
* **Inertia.js** – Server-driven SPA architecture
* **Laravel** – Backend framework
* **Tailwind CSS** – Utility-first CSS framework

---

## 📦 Requirements

* PHP 8.1+
* Composer
* Node.js & npm
* MySQL / MariaDB

---

## 🚀 Installation

1. **Clone the repository**

   ```bash
   git clone https://github.com/your-org/tnts-aspire.git
   cd tnts-aspire
   ```

2. **Install backend dependencies**

   ```bash
   composer install
   ```

3. **Install frontend dependencies**

   ```bash
   npm install
   npm run dev
   ```

4. **Environment setup**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database** in `.env`

6. **Run migrations**

   ```bash
   php artisan migrate
   ```

7. **Serve the application**

   ```bash
   php artisan serve
   ```

---

## 🧱 Project Architecture

* **Laravel** handles authentication, business logic, and data persistence
* **Inertia.js** bridges Laravel and Vue without a separate API
* **Vue.js** manages page components and interactivity
* **Tailwind CSS** ensures consistent and responsive UI design

---

## 🔒 Access Roles

* **Administrator** – Full system control
* **Teacher** – Manage grades and assigned sections
* **Student** – View personal academic records

---

## 🏫 Target Environment

* Designed for **public secondary schools**
* Suitable for **LAN or online deployment**
* Expandable for additional academic modules

---

## 📄 License

This project is intended for internal academic use by **Tanza National Trade School**. Distribution and modification are subject to institutional approval.

---

## 📬 Maintainer

Developed and maintained by the TNTS ASPIRE Development Team.