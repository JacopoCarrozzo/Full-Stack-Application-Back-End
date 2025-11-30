# 🚀 Threls Full-Stack Application: Laravel Backend

This repository contains the **Laravel** backend. It utilizes **Filament** for the admin interface and exposes data via a **JSON API** for consumption by the Next.js frontend.

---

## ⚙️ System Requirements

To run the project, you must have installed:

* **PHP** (v8.3+ recommended)
* **Composer** (PHP dependency management)
* **Node.js / NPM** (JavaScript and Vite dependency management)
* **Git**
* **Local Server:** Herd, XAMPP, MAMP, or Docker (with MySQL/MariaDB).

---

## 💻 Quick Installation Guide

Follow these steps in order to configure and launch the application.

### Phase 1: Cloning and File Setup

| Action | Command to Execute | Description |
| :--- | :--- | :--- |
| **1. Clone the Repository** | `git clone https://github.com/JacopoCarrozzo/Threls-Full-Stack-Application` | Downloads the code. |
| **2. Navigate to Directory** | `cd Threls-Full-Stack-Application` | |
| **3. Configure .env File** | `copy .env.example .env` | Creates the local configuration file. |

### Phase 2: Installing Dependencies and Generating Key

It is **critical** to install PHP dependencies first to enable the `php artisan` command.

| Action | Command to Execute | Description |
| :--- | :--- | :--- |
| **1. Install PHP (Composer)** | `composer install` | **(MUST BE FIRST)** Creates the necessary `vendor` folder. |
| **2. Generate Encryption Key** | `php artisan key:generate` | Essential for application security. |
| **3. Install JavaScript (NPM)** | `npm install` | |

### Phase 3: Database Setup (⚠️ Mandatory)

The application requires a MySQL database.

1.  **Manual Action Required:**
    * You must **manually create an empty database** named **`database_threls`** in your MySQL.

2.  **Verify Credentials in `.env`:**
    * Open your local `.env` file and ensure that `DB_USERNAME`, `DB_PASSWORD`, and `DB_PORT` match your local development credentials.

3.  **Run Migrations:**
    This creates all necessary tables (including `pages`, `menus`, etc.).

    ```bash
    php artisan config:clear
    php artisan migrate
    ```

### Phase 4: Building Assets and Launching

| Action | Command to Execute | Description |
| :--- | :--- | :--- |
| **1. Build Assets (Vite)** | `npm run build` | Generates the `public/build/manifest.json` file, resolving the missing manifest error. |
| **2. Server Startup** | `php artisan serve` | Starts the built-in development server. (If using Herd, your `.test` domain is already active). |

---

## 🎯 Key Access Points

Once the server is started:

### 1. Administration Interface (Filament CMS)

* **URL:** `http://threls-full-stack-application.test/admin`)
* **User Setup:** If you don't have an admin user yet, create one:
    ```bash
    php artisan make:filament-user
    ```

### 2. Public API (Headless)

* **Menu Endpoint:** The API to retrieve the complete menu structure (including linked pages via Eager Loading):
    ```
    http://threls-full-stack-application.test/api/menus
    ```

The project is now ready to be used as a data source for the Next.js frontend.
