composer i
php artisan key:generate
configure .env file (database, JWT_SECRET, L5_SWAGGER_CONST_HOST)
php artisan migrate --seed
php artisan jwt:secret

admin user - email admin@gmail.com, pass 123456
test user - email test@gmail.com, pass 123456

test commands - php artisan test, ./vendor/bin/phpunit
