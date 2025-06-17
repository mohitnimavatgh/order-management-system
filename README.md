````md
# Order Management System

Mini order management system built with Laravel 12 and Nuxt. This project includes basic order creation, listing, status updates, validation, and testing.

---

## Features

- Create, list, and update orders
- REST API using Laravel
- Nuxt 3 frontend using Vuelidate for validation
- Tailwind CSS
- Backend & frontend validation
- PHPUnit tests for API functionality

---

## Tech Stack

- Backend: Laravel 12, MySQL, PHPUnit
- Frontend: Nuxt 3, Vuelidate, Tailwind CSS

---

## How to Run the Project

### Backend Laravel

```bash
cd order-management-backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
````

The Laravel API will be available at: `http://127.0.0.1:8000/api/orders`

### Frontend Nuxt 

```bash
cd order-management-frontend
npm install
npm run dev
```

The frontend will run at: `http://localhost:3000`

---

## Run Backend Unit Tests

```bash
cd order-management-backend
php artisan test
```

---

## Known Issue

In the test task, it was mentioned to use the `PATCH` method to update the order status. However, I encountered a CORS error specifically with `PATCH`, while other API methods worked fine. To resolve this, I used the `PUT` method for updating the status. 

---
