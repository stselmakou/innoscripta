**Case study for innoscripta**
Postman collection is under postman-collection.json
Initial set up:
docker-compose up -d
docker exec -ti app bash
php artisan migrate --seed
to run articles parsing:
php artisan app:innoscripta:retrieve-articles 
php artisan queue:work

