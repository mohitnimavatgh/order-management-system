# order-management-system

## Completed Task

- Add, list, and update orders
- API create with Laravel
- Frontend Using Nuxt 
- Form validation using Vuelidate and backend validation
- Tailwind CSS for clean UI
- PHP Unit tests for backend functionality

## Step to Run

- For backend 

cd order-managment-backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

- For Frontend

cd order-managment-frontend
npm install
npm run dev

## Run Unit Test

cd order-managment-backend
php artisan test
