# Complete Hostinger Deployment Guide for Laravel + Inertia.js (Vue 3)

This guide provides step-by-step instructions to deploy the **DUC Website** (Laravel 11, Inertia.js, Vue 3, Vite, Tailwind CSS) onto **Hostinger Shared Hosting** (hPanel) or **Hostinger VPS**.

---

## 📋 Pre-Deployment Prerequisites

Ensure your Hostinger environment meets these minimum specifications:
- **PHP Version**: `8.3` (Set in Hostinger hPanel -> Advanced -> PHP Configuration)
- **Database**: MySQL 8.0+ or MariaDB 10.3+
- **PHP Extensions Enabled**: `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `gd` or `imagick`
- **Node.js**: Installed on local development machine (for compiling frontend assets).

---

## 🚀 Step 1: Compile Assets & Prepare Files Locally

Before uploading to Hostinger, compile all frontend assets (Vue 3 / Inertia) into static production bundles:

```bash
# 1. Install local dependencies (if not already installed)
npm install

# 2. Build production assets (Outputs to public/build/)
npm run build
```

Verify that the `public/build/` directory exists and contains `manifest.json` and bundled CSS/JS assets.

---

## 🗄️ Step 2: Create MySQL Database in Hostinger hPanel

1. Log in to your **Hostinger hPanel**.
2. Navigate to **Databases** -> **Management** (or **MySQL Databases**).
3. Create a new MySQL Database:
   - **Database Name**: e.g., `u123456789_duc_db`
   - **MySQL Username**: e.g., `u123456789_duc_user`
   - **Password**: *Set a strong password*
4. Click **Create**. Note down the **Database Name**, **Username**, **Host** (`localhost` or `127.0.0.1`), and **Password**.

---

## 📤 Step 3: Upload Project Files to Hostinger

### Option A: Uploading to `public_html` (Most Common Shared Hosting Setup)

1. Compress your project folder into a `.zip` archive on your local computer.
   *Exclusion Tip: You can omit `node_modules` to keep the zip file small.*
2. In **Hostinger hPanel**, open **File Manager**.
3. Navigate to `public_html/`.
4. Upload your `.zip` file into `public_html/` and click **Extract**.
5. Move the extracted files so that the project root is directly inside `public_html/`.

> [!NOTE]
> The included `.htaccess` file in the root directory will automatically route web requests into `public/` while securing sensitive files like `.env` and `storage/`.

---

## ⚙️ Step 4: Configure Production `.env` File

1. In Hostinger **File Manager**, locate `.env.hostinger.example` (or create a `.env` file).
2. Rename/Copy it to `.env`.
3. Edit `.env` with your actual Hostinger details:

```env
APP_NAME="DUC Website"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u123456789_duc_db
DB_USERNAME=u123456789_duc_user
DB_PASSWORD=YOUR_ACTUAL_DB_PASSWORD

SESSION_DRIVER=database
CACHE_STORE=database
FILESYSTEM_DISK=public
```

4. Generate an `APP_KEY` if not already present.

---

## 🛠️ Step 5: Database Migration & Storage Link Setup

### Method 1: Using the Web Setup Helper (Recommended if SSH is disabled)

We have created a pre-built web helper script inside `public/hostinger-setup.php`.

1. Open your browser and go to:
   ```
   https://yourdomain.com/hostinger-setup.php?key=hostinger_duc_setup_2026
   ```
2. Click **Create Storage Link** to link public storage.
3. Click **Run Migrations** to set up database tables.
4. Click **Seed Database** to import default initial website content & settings.
5. Click **Cache App & Routes** to optimize Laravel performance.

> [!WARNING]
> **IMPORTANT SECURITY STEP**: Once setup is complete, delete `public/hostinger-setup.php` or change the `SECRET_KEY` inside the file!

---

### Method 2: Using Hostinger SSH / Terminal

If you have SSH access enabled in Hostinger hPanel (Advanced -> SSH Access):

```bash
# Connect via SSH
ssh u123456789@your-server-ip -p 65002

# Navigate to project directory
cd public_html

# Install production PHP dependencies
composer install --optimize-autoloader --no-dev

# Generate app key if needed
php artisan key:generate

# Run database migrations and seeders
php artisan migrate --force
php artisan db:seed --force

# Link storage
php artisan storage:link

# Cache configuration, routes, and views for optimal performance
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🔐 Step 6: File Permissions & Security Checklist

Ensure proper file permissions in Hostinger File Manager:
- Directories: `755`
- Files: `644`
- `storage` and `bootstrap/cache` directories: `775` or `777` (must be writable by PHP process).

### Enable Free SSL Certificate (HTTPS)
1. In hPanel, go to **Security** -> **SSL**.
2. Click **Install SSL** for your domain (Hostinger provides free unlimited SSL via Let's Encrypt).
3. Ensure `APP_URL` in `.env` uses `https://`.

---

## ❓ Troubleshooting & FAQs

### 1. HTTP 500 Internal Server Error
- **Cause**: PHP version mismatch or missing `.env` / database credentials error.
- **Solution**: Go to Hostinger hPanel -> **PHP Configuration** and ensure **PHP 8.3** is active. Check `storage/logs/laravel.log` for details.

### 2. Images or Uploaded Assets return 404 (e.g. `/storage/events/...`)
- **Cause**: Broken or missing storage symlink, or symlinks disabled on shared hosting.
- **Solution A (Symlink Fix)**:
  1. Visit `https://duc.otp5.com/hostinger-setup.php?key=hostinger_duc_setup_2026&action=storage-link` to automatically remove broken links and recreate the storage symlink.
  2. Or run via SSH: `rm public/storage && php artisan storage:link`.
- **Solution B (Direct Storage Fallback - No Symlink Needed)**:
  If Hostinger shared hosting restricts symlinks, set up direct public storage:
  1. Add `FILESYSTEM_PUBLIC_ROOT=public/storage` to your `.env` file on Hostinger.
  2. Visit `hostinger-setup.php?action=direct-storage` (or manually create the folder `public/storage`).
  3. Click **Clear Cache** in `hostinger-setup.php` or run `php artisan config:clear`.

### 3. Settings or Region / AWS / Domain changes in `.env` do not take effect
- **Cause**: Laravel is serving cached configuration files from `bootstrap/cache/config.php`.
- **Solution**:
  1. Clear config cache by visiting `https://duc.otp5.com/hostinger-setup.php?key=hostinger_duc_setup_2026&action=clear`.
  2. If using S3 or Hostinger Object Storage, ensure `AWS_DEFAULT_REGION` (e.g. `us-east-1` or `eu-central-1`) and `AWS_ENDPOINT` are set in `.env` and run **Clear Cache**.

### 4. Page Refresh on Subroutes Returns 404
- **Cause**: Apache rewrite rules missing.
- **Solution**: Ensure both the root `.htaccess` and `public/.htaccess` files are uploaded and `.htaccess` hidden file visibility is enabled in Hostinger File Manager.

### 5. Database Connection Refused
- **Cause**: Hostinger DB Host is set incorrectly.
- **Solution**: Hostinger MySQL usually uses `127.0.0.1` or `localhost`. Check the exact host listed under **Databases -> MySQL Databases** in hPanel.
