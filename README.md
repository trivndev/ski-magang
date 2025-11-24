# SKI MAGANG

SKI MAGANG is a website for students of SMK Kristen Immanuel Pontianak to share internship information. This platform helps students discover, bookmark, and like internship opportunities, ensuring they always have access to the latest and most relevant internship information easily.

---

## Table of Contents
- [Main Features](#main-features)
- [Entities and CRUD Coverage](#entities-and-crud-coverage)
- [Database Setup](#database-setup)
- [Installation](#installation)
- [Usage](#usage)
- [Architecture & Tech Stack](#architecture--tech-stack)
- [Contributors](#contributors)
- [License](#license)

---

## Main Features
- Public
  - Browse internship listings (home and `/internships`)

- Auth & Profiles
  - User authentication (login & register)
  - Email verification flow (verified routes, re-send verification)
  - Profile management (update name/email with password re-check on email change)
  - Password update (change current password)
  - Appearance settings (theme preferences)

- Internships
  - Create internship posts (form at `/internships/create`)
  - Like/unlike internship posts (per-user likes)
  - Bookmark/unbookmark internship posts (per-user bookmarks)
  - Filtered views: liked posts (`/internships/liked`) and bookmarked posts (`/internships/bookmarked`)

- Administration
  - Admin dashboard (`/admin`) with role-based access control (Admin, Supervisor)
  - Manage users (`/admin/users`)
  - Manage posts (`/admin/posts`)

---

## Entities and CRUD Coverage
Entities directly supporting the main feature “internship posting and discovery” must provide CRUD:

- Internship
  - Create: users can submit new internship posts
  - Read: list/detail views of internships
  - Update: authors/admins can update posts (where permitted)
  - Delete: authors/admins can delete posts (where permitted)
- User
  - Admin can manage users from the admin dashboard
- Post Status (InternshipsPostStatus)
  - Used to manage state of internship posts (seeded and used by the app)

Access control and settings related entities:
- Roles/Permissions
  - Route middleware enforces roles: `admin` and `supervisor` for admin area
- User Settings
  - Profile, Password, Appearance are managed per-user

Additional feature interactions:
- Likes and bookmarks per user for internships

Routes overview (non‑exhaustive):
- Public home: `/`
- Internships index: `/internships`
- Authenticated: create `/internships/create`, liked `/internships/liked`, bookmarked `/internships/bookmarked`
- Admin dashboard: `/admin`, manage users `/admin/users`, manage posts `/admin/posts`

---

## Database Setup
Configure your database in the `.env` file. Example environment keys:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ski_magang
DB_USERNAME=root
DB_PASSWORD=secret
```

Then run migrations and seeders to prepare required tables and initial data (including post statuses and sample data if provided by seeders):

```
php artisan migrate --seed
```

---

## Installation

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & npm
- Database (MySQL/PostgreSQL)

### Installation Steps
1. Clone the repository
   ```bash
   git clone https://github.com/trivndev/ski-magang.git
   cd ski-magang
   ```
2. Install PHP dependencies
   ```bash
   composer install
   ```
3. Install frontend dependencies
   ```bash
   npm install
   ```
4. Copy environment file
   ```bash
   cp .env.example .env
   ```
5. Configure the database
    - Edit the `.env` file and adjust your database settings.
6. Generate application key
   ```bash
   php artisan key:generate
   ```
7. Run migrations and seeders
   ```bash
   php artisan migrate --seed
   ```
8. Build frontend assets (for production)
   ```bash
   npm run build
   ```
   For local development you can also run the Vite dev server in another terminal:
   ```bash
   npm run dev
   ```
9. Start the local server
   ```bash
   php artisan serve
   ```

---

## Usage
1. Login/Register
    - Users can create a new account or log in with an existing account.
2. Add Internship Information
    - After logging in, users can add new internship opportunities using the provided form.
3. View Internship Information
    - All users can browse the list of available internships.
4. Bookmark & Like
    - Users can bookmark their favorite internships and like opportunities they are interested in.
5. Profile & Settings
    - Update profile, change password, and adjust appearance.
6. Admin Dashboard
    - Admins/Supervisors can manage users and posts.

---

## Architecture & Tech Stack
- Backend: Laravel
- Frontend: Livewire, Tailwind CSS, Alpine.js
- Database: MySQL/PostgreSQL
- Build Tool: Vite

### Main Folder Structure
- `app/` : Application logic (Models, Livewire Components, Traits)
- `resources/views/` : Blade view files
- `routes/` : Application routing
- `public/` : Static files and application entry point
- `database/` : Migrations, seeders, and factories

---

## Contributors
- Nicolas — Full‑stack Developer, implemented the Figma design into the website
- Ethan & Vincent — UI/UX Designers, created the Figma design for this website

---

## License

This project is licensed under the Polyform Noncommercial License 1.0.0.
You may use, modify, and share it for noncommercial purposes only.
See [LICENSE](./LICENSE) for full text.
