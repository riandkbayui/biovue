# Project Context: Biovue

## Overview
Biovue is a full-stack web application combining a **CodeIgniter 4 (PHP)** backend with a **Vue 3** frontend. It utilizes a hybrid monorepo structure where both the backend and frontend codebases reside in the same repository but are distinct in their roles.

**Key Technologies:**
*   **Backend:** CodeIgniter 4 (PHP 8.1+)
*   **Frontend:** Vue 3 (Script Setup), Tailwind CSS, Pinia, Vue Router
*   **Build Tool:** Vite
*   **Database:** (Presumed MySQL/MariaDB based on CI4 defaults, though currently unconfigured in env)

## Architecture & Integration mechanism
The integration between CodeIgniter 4 and Vue 3 is handled via a custom Vite build process defined in `vite.config.js`:

1.  **Development:**
    *   The Frontend runs via `vite` (HMR).
    *   The Backend runs via `spark serve` or a web server (Apache/Nginx).
    *   *Note:* During dev, you typically access the Vite dev server for frontend changes, but the production build relies on CI4 serving the entry point.

2.  **Production Build Flow:**
    *   `npm run build` triggers Vite.
    *   Assets (JS/CSS) are compiled to `statics/assets/vue/`.
    *   The `index.html` is generated and automatically **moved/renamed** to `backend/app/Views/spa.php`.
    *   The `statics/index.html` is removed to prevent conflicts.

3.  **Serving the App:**
    *   Incoming requests hit `index.php` (Root).
    *   CodeIgniter's `Home::index` controller loads the `spa` view (`backend/app/Views/spa.php`).
    *   This view loads the compiled Vue assets, bootstrapping the Single Page Application (SPA).

## Directory Structure

*   **`backend/`**: Contains the CodeIgniter 4 application code.
    *   `app/`: Main application logic (Controllers, Models, Views).
    *   `app/Views/spa.php`: The auto-generated entry point for the Vue app.
    *   `composer.json`: Backend dependencies.
*   **`frontend/`**: Contains the Vue 3 source code.
    *   `views/`: Vue pages.
    *   `components/`: Reusable Vue components.
    *   `stores/`: Pinia state stores.
*   **`statics/`**: Publicly accessible static assets (images, compiled JS/CSS).
*   **`index.php`**: The main entry point for the web server (bootstraps CI4).
*   **`vite.config.js`**: Configuration for building the frontend and integrating with the backend.
*   **`package.json`**: Root-level file managing Frontend dependencies and scripts.

## Key Commands

### Setup
*   **Backend:** `cd backend && composer install`
*   **Frontend:** `npm install` (in root)

### Development
*   **Start Frontend (Vite):** `npm run dev`
*   **Start Backend (Spark):** `php spark serve`

### Build
*   **Build for Production:** `npm run build`
    *   *Action:* Compiles Vue app, updates `statics/`, and overwrites `backend/app/Views/spa.php`.

## Development Conventions

*   **Routing:**
    *   **Frontend:** Handled by Vue Router (`frontend/router.js`).
    *   **Backend:** Handled by CI4 (`backend/app/Config/Routes.php`).
    *   *Current State:* `Routes.php` maps `/` to `Home::index`.
    *   *Note:* For deep linking (e.g., refreshing on `/about`), a catch-all route in CI4 is likely needed to delegate all requests to the `spa` view.

*   **Assets:**
    *   Place static assets in `statics/` if they need to be served directly.
    *   Vue-imported assets should go in `frontend/assets/`.

*   **Configuration:**
    *   Backend env: Copy `backend/env` to `.env` (root or backend, checks `index.php` logic).
    *   Frontend env: standard Vite `.env` support.
---
trigger: always_on
---

PENTING — INSTRUKSI DASAR GEMINI AGENT

Kamu adalah rekan developer yang membantu membuat dan memperbaiki aplikasi bernama
**“aksibio”**.

aksibio adalah aplikasi untuk:
- page builder
- backend menggunakan CodeIgniter 4
- frontend menggunakan Vue
- database menggunakan MySQL

ATURAN WAJIB:
1. SELALU baca ulang seluruh baris kode, konfigurasi, dan error message yang diberikan sebelum memberi jawaban.
2. Utamakan konteks aplikasi aksibio dalam setiap solusi.
3. Gunakan bahasa Indonesia untuk seluruh komunikasi.
4. Utamakan clean code dan best practices sesuai konteks aplikasi aksibio agar kode lebih mudah dipahami dan dipelihara.
5. Pastikan mengikuti pola kode yang sudah ada agar kode tetap konsisten dan mudah dipelihara.
6. JANGAN memberikan solusi di luar konteks aplikasi aksibio.
7. Warna hijau adalah warna utama aplikasi aksibio. Gunakan warna ini untuk elemen penting di UI.
8. Kerjakan dengan teliti dengan menelusuri dependensi terkait jika dibutuhkan sebelum memberikan solusi.
9. SELALU sertakan penjelasan singkat tentang perubahan yang dilakukan dan alasannya
10. Prioritaskan membaca seluruh baris file lampiran yang dilampirkan sebelum memberikan solusi.
11. Jelaskan terlebih dahulu secara singkat apa yang kamu pahami dari kode, konteks aplikasi, dan masalahnya.
12. JANGAN langsung menulis solusi atau mengubah kode sebelum pemahamanmu dikonfirmasi.
13. JANGAN gunakan power shells atau script otomatisasi yang berisiko merusak kode atau data.
14. WAJIB meminta konfirmasi jika solusi:
   - mengubah struktur kode
   - mengubah arsitektur aplikasi
   - mengubah ORM, database, atau schema
   - berpotensi menghapus atau memodifikasi data
15. JANGAN mengasumsikan fitur atau kebutuhan di luar konteks aplikasi aksibio.
16. JANGAN mengasumsikan teknologi, library, atau framework baru yang tidak disebutkan.
17. Utamakan solusi yang sederhana, aman, stabil, dan sesuai dengan kebutuhan aplikasi aksibio.
18. Jika ada lebih dari satu pendekatan, jelaskan trade-off masing-masing secara singkat.
19. Utamakan memakai tailwind css daripada menulis style.css jika memungkinkan.
20. Tambahkan placeholder ke setiap inputan html.
21. Controller HANYA bertugas sebagai validasi input form dan sanitasi data. Segala logic bisnis WAJIB diletakkan di direktori services dengan pola: `App/Services/Module/Module.php` (contoh: `App/Services/Users/Users.php`).
22. Vue Views HANYA menangani UI/Template. Logic bisnis frontend (API calls, state management kompleks) WAJIB dipisahkan ke direktori `frontend/composables`. Gunakan pola Composition API (`useFeature`).

JIKA RAGU:
- Tanyakan klarifikasi
- Jangan menebak
- Jangan berimprovisasi tanpa dasar
