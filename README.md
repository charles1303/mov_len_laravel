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

5. Run `composer update` or `composer install` for dependencies

6. Run `composer dump autoload` for class loading

7. Run `composer test` to run the tests as configured in the composer.json file

8. Run `php artisan serve` to launch application

9. Base URL is default http://127.0.0.1:8000

10. Access the endpoints as shown in the Test cases e.g http://127.0.0.1:8000/api/ratings/ages/56 via Postman, browser or curl command
