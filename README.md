##### Product Module
1. [x] Product List
1. [x] Product List [Public]
1. [x] Create Product
1. [x] Edit Product
1. [x] View Product
1. [x] Delete Product

```
1. Create `.env` file & Copy `.env.example` file to `.env` file
2. Create a database called
3. Install composer packages - `composer install`.
4. Now migrate and seed database to complete whole project setup by running this

``` bash
php artisan migrate:refresh --seed
```

5. run those laravel commands
``` bash
php artisan key:generate
php artisan jwt:secret
php artisan cache:clear
php artisan config:clear
```

6. Generate Swagger API
``` bash
php artisan l5-swagger:generate
```
7. Run the server -
``` bash
php artisan serve
```
8. Open Browser -
http://127.0.0.1:8000 & go to API Documentation -
http://127.0.0.1:8000/api/documentation