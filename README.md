# OMS Laravel - Order Management System

A simple commercial Order Management System (OMS) built using Laravel and Bootstrap. The app supports two roles: `admin` and `staff`. Admin users can manage products, customers, and orders. Staff users have limited dashboard access.

## 🚀 Features

- User authentication with roles (`admin`, `staff`)
- Product, Customer, and Order management
- Admin-only access to full dashboard and CRUD operations
- Seeder for demo data (customers, products, orders)
- Role-based navigation and dashboard view

---

## 📦 Requirements

- PHP 8.1+
- Composer
- MySQL
- Node.js & NPM (for frontend assets)
- Laravel 10+

---

## 🛠️ Installation

```bash
# Clone the repository
git clone https://github.com/wahyuwiro/oms-laravel.git

# Navigate to project directory
cd oms-laravel

# Install PHP dependencies
composer install

# Copy .env and configure DB settings
cp .env.example .env

# Generate app key
php artisan key:generate

# Install frontend dependencies
npm install && npm run dev
```

## 🧪 Run Migrations and Seeders

```bash
# Run database migrations
php artisan migrate

# Seed demo data (customers, products, orders, roles, users)
php artisan migrate:fresh --seed
```

## 📋 Demo Users
After seeding, you can log in using:

| Role   | Email                    | Password  |
|--------|--------------------------|-----------|
| Admin  | `phawiro@gmail.com`      | `password`|
| Staff  | `phawiro+staff@gmail.com`| `password`|

> ℹ️ You can log in using these credentials after seeding the database.

## 🧩 Role-Based Access
- ```admin``` has full access to all modules and navigation items.
- ```staff``` can only view a limited dashboard (staff.dashboard).

