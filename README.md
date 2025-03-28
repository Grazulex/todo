# Project Title

## Description
Brief description of the project.

## Installation Process
1. Clone the repository:
    ```bash
    git clone https://github.com/Grazulex/todo
    cd yourproject
    ```
2. Install PHP dependencies:
    ```bash
    composer install
    ```
3. Install JavaScript dependencies:
    ```bash
    npm install
    ```
4. Copy the `.env.example` file to `.env`:
    ```bash
    cp .env.example .env
    ```
5. Generate an application key:
    ```bash
    php artisan key:generate
    ```
6. Run the database migrations:
    ```bash
    php artisan migrate
    ```

## Testing Process
1. Run PHP linter:
    ```bash
    vendor/bin/pint
    ```
2. Run PHP tests:
    ```bash
    vendor/bin/peck
    ```
