Laravel Project

Overview

This is a Laravel project designed for backend API development, which can be connected to a Flutter application.

Prerequisites

Before you begin, ensure you have the following installed:

    * PHP (latest stable version)

    * Composer

    * MySQL or PostgreSQL database

    * Laravel installer

* Installation

    1. Clone the repository:

        git clone https://github.com/w1885921/backendFitJourney
        cd backendFitJourney
    
    2. Install dependencies:

        composer install

    3. Set up the .env file:

        cp .env.example .env
    
    4. Configure database in .env:

        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=your_database
        DB_USERNAME=your_username
        DB_PASSWORD=your_password

    5. Run Migration:

        php artisan migrate

    6. Run Seeder:
        php artisan db:seed

    7. Start the Laravel server:

        php artisan serve --host=0.0.0.0
