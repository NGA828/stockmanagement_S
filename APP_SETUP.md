# Stock Management System - Setup Guide

This guide outlines the steps required to set up and run the Stock Management System locally.

## Prerequisites
Before you begin, ensure you have the following installed on your system:
- **PHP 8.2 or higher**
- **Composer** (PHP dependency manager)
- **Node.js & npm**
- **MySQL/MariaDB** (via XAMPP, Laragon, or standalone)

---

## 1. Installation Steps

### Step 1: Clone the Repository
```bash
git clone <your-repository-url>
cd stockmanagement_S
```

### Step 2: Install PHP Dependencies
```bash
composer install
```

### Step 3: Install Frontend Dependencies
```bash
npm install
```

### Step 4: Environment Configuration
Copy the example environment file and configure your database settings:
```bash
cp .env.example .env
```
Open the `.env` file and update the following lines with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stockmanagement
DB_USERNAME=root
DB_PASSWORD=
```

### Step 5: Generate Application Key
```bash
php artisan key:generate
```

### Step 6: Database Setup
Create a database named `stockmanagement` in your MySQL server, then run the migrations and seeders:
```bash
php artisan migrate --seed
```

### Step 7: Create Storage Link
Link the storage directory to the public directory (required for item images):
```bash
php artisan storage:link
```

### Step 8: Build Frontend Assets
Compile the CSS and JS files using Vite:
```bash
npm run build
```

---

## 2. Running the Application

Start the local development server:
```bash
php artisan serve
```
The application will be accessible at: `http://127.0.0.1:8000`

---

## 3. Default Login Credentials
After running the seeders (`php artisan migrate --seed`), you can log in with the following accounts:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@example.com` | `password` |
| **Stock Manager** | `manager@example.com` | `password` |
| **Warehouse Staff** | `staff@example.com` | `password` |

---

## 4. Troubleshooting
- **Images not showing**: Ensure you ran `php artisan storage:link`.
- **Database Error**: Check your `.env` file for correct database name, username, and password.
- **Style issues**: Ensure you ran `npm run build` or have `npm run dev` running in the background.
