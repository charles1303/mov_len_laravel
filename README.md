# mov_len_laravel
Simple Application Structure for Laravel REST API

1. Rename the file .env.example to .env

2. Open the renamed file and fill in values for the following variables:
LOG_FILE="${PATH_TO_APPLICATION_LOG_FILE}"

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=movies_production
DB_USERNAME=
DB_PASSWORD=

3. Install composer if not installed already 

4. Navigate into project root folder

5. Run `php artisan key:generate` to generate application key for the APP_KEY value in the .env file so as to secure your user sessions and other encrypted data and prevent the `No supported encrypter found` error

6. Run `composer update` or `composer install` for dependencies

7. Run `composer dump autoload` for class loading

8. Run `composer test` to run the tests as configured in the composer.json file

9. Run `php artisan serve` to launch application

10. Base URL is default http://127.0.0.1:8000

11. Access the endpoints as shown in the Test cases e.g http://127.0.0.1:8000/api/ratings/ages/56 via Postman, browser or curl command
