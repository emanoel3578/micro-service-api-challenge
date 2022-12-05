# micro-service-api-challenge

1. docker-compose build
2. docker-compose up -d
2. docker exec -it api-download-app bash
3. composer install
4. php artisan key:generate
5. php artisan migrate:fresh --seed
6. php artisan test
7. route for testing downloading the file: localhost:8000/api/download ex: http://localhost:8000/api/download?id=9&dateStart=2022-12-04 00:00:00&dateEnd=2022-12-06 00:00:00

ie. env.example has all the needed values for testing