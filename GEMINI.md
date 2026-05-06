# Portfolio Admin Panel

A comprehensive admin dashboard for managing portfolio content, built with Laravel 13, Inertia.js 3, and Vue 3.

## Project Overview

- **Backend:** Laravel 13 (PHP 8.3+)
- **Frontend:** Vue 3 (Composition API), Inertia.js 3, TypeScript
- **Styling:** Tailwind CSS 4, shadcn-vue
- **Architecture:** 
    - **Routing:** Separate route files (e.g., `routes/admin.php`) for logical separation.
    - **Controllers:** Granular controller structure. View actions (index, create, edit) are often grouped (e.g., `ViewCategoryController`), while data-modifying actions are implemented as single-action controllers (e.g., `StoreCategoryController`).
    - **Authentication:** Multi-auth setup with `web` (User) and `admin` (Admin) guards.
    - **Features:** Article management, Category and Tag systems, TipTap rich text editor.
- **Key Libraries:**
    - `inertiajs/inertia-laravel`: Seamless SPA experience.
    - `spatie/laravel-sluggable`: Automatic slug generation for articles/categories.
    - `laravel/wayfinder`: Specialized Vite plugin for routing and page resolution.
    - `tanstack/vue-table`: Powerful data tables for admin lists.
    - `lucide-vue-next`: Icon set.

## Building and Running

### Prerequisites
- PHP 8.3+
- Node.js & NPM
- Composer

### Key Commands

- **Setup:** `composer run setup`
  - Installs dependencies, copies `.env`, generates keys, runs migrations, and builds assets.
- **Development:** `composer run dev`
  - Runs PHP server, Vite dev server, queue listener, and Pail (log viewer) concurrently.
- **Production Build:** `npm run build`
- **Linting:** 
  - PHP: `composer run lint` (using Laravel Pint)
  - JS/Vue: `npm run lint` and `npm run format`
- **Type Checking:** `npm run types:check`

## Testing

- **Run all tests:** `composer run test` or `php artisan test`
- **CI Check:** `composer run ci:check`
  - Runs linting, type checks, and tests in sequence.

## Development Conventions

### Backend
- **Controller Organization:** Controllers are located in `app/Http/Controllers/Admin/`. They are grouped by resource subdirectories.
- **Models:** Uses modern Laravel features like Model Attributes (e.g., `#[Fillable]`).
- **Resources:** API resources are used for consistent data transformation to the frontend (`app/Http/Resources/`).

### Frontend
- **Components:** UI components follow the `shadcn-vue` pattern and are located in `resources/js/components/ui`.
- **Pages:** Inertia pages are located in `resources/js/pages/`.
- **State Management:** Primarily handled via Inertia props and Vue Composition API (composables).
- **Icons:** Use `lucide-vue-next`.

### General
- **Naming:** Follow PSR-12 for PHP and standard Vue/TypeScript conventions.
- **Commits:** Clear, concise messages focusing on "why" rather than just "what".
