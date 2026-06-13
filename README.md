# GeoCrime Web 🗺️👮

GeoCrime Web adalah aplikasi web berbasis framework Laravel (dengan Vite dan TailwindCSS) untuk visualisasi dan pemetaan data kriminalitas berbasis geografis.

Dokumentasi ini menjelaskan langkah-langkah instalasi proyek dari awal di komputer lokal Anda.

---

## 📋 Prasyarat Sistem

Sebelum memulai, pastikan perangkat Anda sudah terinstal tools berikut:
*   **PHP** (versi 8.2 atau lebih baru direkomendasikan)
*   **Composer** (pengelola package PHP)
*   **Node.js** & **NPM** (versi LTS terbaru)
*   **Git**
*   **Database Engine** (SQLite/MySQL/PostgreSQL)

---

## 🚀 Langkah 1: Clone Repositori

Buka terminal atau command prompt Anda, lalu jalankan perintah berikut untuk menyalin proyek ke komputer lokal:

```bash
git clone <URL_REPOSITORI_SEKARANG> GeoCrime-web
cd GeoCrime-web
```

---

## 🛠️ Langkah 2: Instalasi Dependensi

Proyek ini menggunakan dependensi backend (PHP/Laravel) dan frontend (JS/TailwindCSS).

### A. Instalasi Dependensi Backend (Composer)
```bash
composer install
```

### B. Instalasi Dependensi Frontend (NPM)
```bash
npm install
```

---

## ⚙️ Langkah 3: Konfigurasi Environment

1.  Salin file `.env.example` menjadi `.env`:
    ```bash
    cp .env.example .env
    ```
    *(Untuk Windows PowerShell, gunakan `copy .env.example .env`)*

2.  Buka file `.env` di text editor pilihan Anda (misalnya VS Code) dan sesuaikan konfigurasi database.
    *   Jika menggunakan **SQLite** (bawaan default):
        ```env
        DB_CONNECTION=sqlite
        ```
        *(Buat file database kosong bernama `database.sqlite` di dalam folder `database/` jika belum ada)*
    *   Jika menggunakan **MySQL**:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=nama_database_anda
        DB_USERNAME=username_mysql_anda
        DB_PASSWORD=password_mysql_anda
        ```

3.  Generate kunci enkripsi aplikasi (App Key):
    ```bash
    php artisan key:generate
    ```

---

## 🗄️ Langkah 4: Migrasi & Database Seeding

Jalankan migrasi database untuk membuat tabel-tabel yang diperlukan oleh aplikasi:

```bash
php artisan migrate
```

*Jika proyek memiliki data awal (seeder), Anda dapat menjalankan:*
```bash
php artisan migrate --seed
```

---

## 💻 Langkah 5: Menjalankan Aplikasi di Lokal

Untuk menjalankan aplikasi di lingkungan pengembangan lokal, Anda perlu menyalakan server backend Laravel dan server kompilasi frontend Vite secara bersamaan.

### A. Jalankan Server Laravel Backend
```bash
php artisan serve
```
Aplikasi Anda sekarang dapat diakses melalui browser di `http://127.0.0.1:8000`.

### B. Jalankan Server Kompilasi Frontend (Vite)
Buka terminal baru di direktori yang sama, lalu jalankan:
```bash
npm run dev
```

