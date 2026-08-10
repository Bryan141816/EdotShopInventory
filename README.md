# EdotShop Inventory

EdotShop Inventory is a web-based inventory management system built using Laravel and MySQL.

## Technologies

* Laravel
* PHP
* MySQL
* Blade
* Tailwind CSS
* JavaScript

## Requirements

* PHP
* Composer
* MySQL
* Node.js and npm

## Installation

Clone the repository:

```bash
git clone <repository-url>
cd EdotShop-Inventory
```

Install dependencies:

```bash
composer install
npm install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure the MySQL database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=edotshop_inventory
DB_USERNAME=root
DB_PASSWORD=
```

Run the migrations:

```bash
php artisan migrate
```

Start the development server:

```bash
php artisan serve
```

For frontend development, run:

```bash
npm run dev
```

The application will be available at:

```text
http://127.0.0.1:8000
```

## Author

Bryan Antier
