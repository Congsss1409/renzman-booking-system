# Renzman Booking System

<p align="center"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="320" alt="Laravel Logo"></p>

## 🚀 What this project is

Renzman Booking System is a small spa & massage booking application built with Laravel. It includes an admin dashboard, therapist management, booking flows, email notifications, payroll generation, CSV export, and PDF export for payroll reports.

This README focuses on how to run the app on a desktop/PC that does NOT have Composer or Node installed.

---

## ✨ Key features

- Multi-branch booking management
- Therapist availability and status tracking
- Multi-step booking flow (Alpine.js + Blade) and email confirmations
- Payments and downpayment handling
- Automatic payroll generation from completed bookings (per-therapist, per-day)
- Payroll itemization and payments tracking
- 60/40 split by default (therapist / owner) for payrolls
- CSV export for reports
- Per-payroll PDF export (server-side using dompdf)
- Real-time event broadcasting for updates (Pusher / Echo)

---

## 💡 Run on a PC without Composer or Node

You have two practical options when your desktop doesn't have Composer or Node: use XAMPP (recommended for Windows) or use Docker. The key requirement for both is that the project must contain the `vendor/` directory and built frontend assets (`public/build` or `public/js` + `public/css`). If those folders are missing, see "Bring built assets/vendor from another machine" below.

### Option A — Use XAMPP (Windows)

1. Install XAMPP (https://www.apachefriends.org) and start Apache + MySQL.
2. Place the project in XAMPP's htdocs, e.g. `C:\xampp\htdocs\renzman-booking-system`.
3. Ensure `vendor/` and `public/build` exist in the project. If they're not present, follow the section below about copying them from another machine.
4. Copy the env file and edit DB settings:

```powershell
cd C:\xampp\htdocs\renzman-booking-system
copy .env.example .env
```

Edit `.env` and set:

- APP_URL=http://localhost/renzman-booking-system
- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=renzman
- DB_USERNAME=root
- DB_PASSWORD=

5. Create the `renzman` database using phpMyAdmin (http://localhost/phpmyadmin) or the MySQL CLI.
6. Use XAMPP's PHP binary to run artisan commands (requires `vendor/` to exist):

```powershell
C:\xampp\php\php.exe artisan key:generate
C:\xampp\php\php.exe artisan migrate --force
```

7. Open the app in your browser:

http://localhost/renzman-booking-system/public

(Optional: create an Apache virtual host pointing to the `public` folder.)

### Option B — Use Docker (no Composer/Node on host)

If Docker Desktop is available, mount the project into a PHP + Apache container and run a MySQL container.

Example quick commands (PowerShell):

```powershell
# network
docker network create renzman-net

# mysql
docker run -d --name renzman-mysql --network renzman-net -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=renzman -p 3306:3306 mysql:8

# php/apache container
docker run -d --name renzman-php --network renzman-net -v C:/xampp/htdocs/renzman-booking-system:/var/www/html -p 8080:80 php:8.1-apache

# access at http://localhost:8080
```

Note: the container approach still requires `vendor/` and built assets in the project directory. See next section.

---

## 📦 Bring built assets / vendor from another machine

If you have another machine with Composer and Node installed (or if you can provision a temporary environment), do the following there and copy the results to the target PC.

On the machine with Composer & Node:

```bash
# install server deps
composer install --no-dev --optimize-autoloader

# frontend build
npm install
npm run build
```

Copy the following folders to the target PC's project root:

- `vendor/` (complete)
- `public/build/` (or `public/js`, `public/css` if used by the project)

After copying, follow the XAMPP or Docker steps above and run `artisan migrate` using the available PHP binary.

---

## ✅ Quick checklist

- PHP 8+ available (XAMPP includes PHP)
- Apache (XAMPP) or Docker container serving `public/`
- `vendor/` exists and is complete
- `public/build` or built assets exist
- Writable `storage/` and `bootstrap/cache`

## 🕒 Automate scheduled tasks (Windows)

1. Open Task Scheduler → Create Task → set it to run whether user is logged on or not.
2. On the **Triggers** tab add a new trigger: Daily, repeat task every 1 minute, indefinitely.
3. On the **Actions** tab add `C:\xampp\php\php.exe` as the program, set **Start in** to `C:\xampp\htdocs\renzman-booking-system`, and use `artisan schedule:run` as arguments.
4. Save the task and run it once manually to verify; check `storage/logs/laravel.log` for scheduler output.

---

## 🧾 Payroll & PDF export notes

- The app uses `barryvdh/laravel-dompdf` for server-side PDF generation. The Export PDF button will generate a PDF if `vendor/` includes this package.
- Payrolls are generated from completed bookings and split 60% to the therapist and 40% to the owner by default. Payrolls include itemization and payments.

---

## �️ Favicon and site branding

- A site-wide favicon has been added to make the app show your brand in browser tabs. The following Blade layout files were updated to reference a single favicon file at `public/favicon.png`:
	- `resources/views/layouts/app.blade.php`
	- `resources/views/layouts/admin.blade.php`
	- `resources/views/layouts/Booking.blade.php`

- A placeholder `public/favicon.png` (small PNG) was added so the site will immediately serve a favicon. Replace that file with your preferred image (your attached logo) to show your real favicon.

How to replace the placeholder (Windows PowerShell):

```powershell
# copy your image into the project public folder (rename if needed)
cp C:\path\to\your\renzman-logo.png C:\xampp\htdocs\renzman-booking-system\public\favicon.png
```

Browser caching note: browsers cache favicons aggressively. After replacing the file, clear cache, hard-refresh, or open the site in a private/incognito window to see the change immediately.

Optional — generate multi-size favicons (recommended)
- For best cross-browser and device support you can generate a set of icons and an ICO file. A quick way locally is to use an online favicon generator or install a CLI tool like ImageMagick and run:

```powershell
# Example (ImageMagick required)
magick convert public\favicon.png -define icon:auto-resize=64,48,32,16 public\favicon.ico
magick convert public\favicon.png -resize 180x180 public\apple-touch-icon.png
```

Then add additional link tags to the layouts (optional) pointing to the generated files:

```html
<link rel="icon" type="image/png" href="{{ asset('favicon-32x32.png') }}" sizes="32x32">
<link rel="icon" type="image/png" href="{{ asset('favicon-16x16.png') }}" sizes="16x16">
<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
```


---

## �🛠 Troubleshooting

- "Missing vendor" — either run Composer on another machine and copy `vendor/`, or install Composer locally.
- "Missing public/build" — build assets on another machine and copy `public/build`.
- Permissions on Windows — ensure Apache/PHP user can write to `storage/` and `bootstrap/cache`.
- Database connection — double-check `.env` and that MySQL is running.

---

## 🎯 When you have Composer & Node later (developer flow)

```powershell
# server deps
composer install

# frontend build (dev)
npm install
npm run dev

# migrations + seeds
php artisan migrate --seed

# serve for development
php artisan serve
```

---

## Project structure highlights

- `app/Models` — Booking, Branch, Therapist, Payroll
- `app/Http/Controllers/PayrollController.php` — payroll generation, items, payments, CSV/PDF
- `resources/views/payrolls` — admin UI and PDF blade
- `database/migrations` — schema

---



---

## License

MIT

---

Made with ❤️ — enjoy managing bookings and payrolls!
