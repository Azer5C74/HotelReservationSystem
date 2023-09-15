# Project description
In this hotel management service we have multiple entities guests, users, hotels,
rooms, and reservations. We have two user roles: Staff and Guest. Some endpints are
restricted for hotel staff users. For that we developed the check role custom middleware.

# Run The project
You need to have docker-compose and docker installed

# Run this command to start the laravel and mysql services
```
sudo docker-compose up --build
```
# Run this command inside the docker container to seed the database
```
php artisan db:seed --class=DatabaseSeeder
```
