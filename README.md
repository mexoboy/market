# Start application in local machine
1. Install docker & docker-compose by using [instruction](https://docs.docker.com/get-docker) on your local machine
2. Copy the .env.development file to .env and change environment params if it necessary 
3. Start docker compose by using command `docker-compose up -d`
4. Install composer dependency `docker-compose exec php composer install`
5. Run migration in container `docker-compose exec php php artisan migrate`
6. Open http://localhost or http://localhost:{PORT} if you was change HTTP_LOCAL_PORT parameter in your environment file

# Before run test
1. Create testing database `docker-compose exec db createdb market_test`
2. Run test inside container by using command `docker-compose exec php php artisan test`
