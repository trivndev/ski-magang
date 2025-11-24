# SKI MAGANG

SKI MAGANG is a website for students of SMK Kristen Immanuel Pontianak to share internship information. This platform helps students discover, bookmark, and like internship opportunities, ensuring they always have access to the latest and most relevant internship information easily.

---

## Table of Contents
- [Main Features](#main-features)
- [Installation](#installation)
- [Usage](#usage)
- [Architecture & Tech Stack](#architecture--tech-stack)
- [Deployment (Railway)](#deployment-railway)
- [Contributors](#contributors)
- [License](#license)

---

## Main Features
- User authentication (login & register)
- Add internship information
- View internship listings
- Bookmark internship opportunities
- Like internship opportunities

---

## Installation

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & npm
- Database (MySQL/PostgreSQL)

### Installation Steps
1. **Clone the repository**
   ```bash
   git clone https://github.com/trivndev/ski-magang.git
   cd ski-magang
   ```
2. **Install PHP dependencies**
   ```bash
   composer install
   ```
3. **Install frontend dependencies**
   ```bash
   npm install
   ```
4. **Copy environment file**
   ```bash
   cp .env.example .env
   ```
5. **Configure the database**
    - Edit the `.env` file and adjust your database settings.
6. **Generate application key**
   ```bash
   php artisan key:generate
   ```
7. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```
8. **Build frontend assets**
   ```bash
   npm run build
   ```
9. **Start the local server**
   ```bash
   php artisan serve
   ```

---

## Usage
1. **Login/Register**
    - Users can create a new account or log in with an existing account.
2. **Add Internship Information**
    - After logging in, users can add new internship opportunities using the provided form.
3. **View Internship Information**
    - All users can browse the list of available internships.
4. **Bookmark & Like**
    - Users can bookmark their favorite internships and like opportunities they are interested in.

---

## Architecture & Tech Stack
- **Backend:** Laravel
- **Frontend:** Livewire, Tailwind CSS, Alpine.js
- **Database:** MySQL/PostgreSQL
- **Build Tool:** Vite

### Main Folder Structure
- `app/` : Application logic (Controllers, Models, Livewire Components)
- `resources/views/` : Blade view files
- `routes/` : Application routing
- `public/` : Static files and application entry point
- `database/` : Migrations, seeders, and factories

---

## Contributors
- **Nicolas**: Fullstack Developer, implemented the Figma design into the website
- **Ethan & Vincent**: UI/UX Designers, created the Figma design for this website

---

## License

## License
This project is licensed under the Polyform Noncommercial License 1.0.0.  
You may use, modify, and share it for noncommercial purposes only.  
See [LICENSE](./LICENSE) for full text.

---

## Deployment (Railway)

This project includes a Dockerfile optimized for Railway using FrankenPHP (Octane).

Steps:
- Create a new Railway project and select “Deploy from Repository”.
- Ensure Railway uses the Dockerfile at the repository root.
- Configure environment variables:
  - APP_ENV=production
  - APP_DEBUG=false
  - APP_KEY=base64:... (required)
  - DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD (as needed)
  - PORT will be provided by Railway automatically
- On first deploy, run migrations (from the Railway shell):
  - php artisan migrate --force

Notes:
- Static assets are built during the Docker build stage with Vite and copied to public/build.
- The server listens on 0.0.0.0:$PORT using Laravel Octane with FrankenPHP.
