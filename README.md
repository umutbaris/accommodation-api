# accommodation-api

**Technologies used**
- Docker
- PHP 7.2
- Laravel Framework 7.0
- MySQL
- Nginx 


## 1. Installation

- Clone The Project

   `git clone https://github.com/umutbaris/accommodation-api.git` 
- Building Docker

   `docker-compose build`
- You should create .env file. You can replace .env.example file as .env All properties are valid.
- Join The Container

  `docker exec -it accommodation_fpm  bash`
- Run to composer update command in the container

  `composer update`
- Final step please run the migrate and seed command in the container to create database tables

  `php artisan migrate:fresh --seed`
  
  Feel free to reach me if you face problem for any installation step.
## 2. OpenAPI Spec
You can reach the API details with the [OpenApiSpec.yml](https://github.com/umutbaris/accommodation-api/blob/main/OpenApiSpec.yml)


## 3. Database Schema
![DB_Schema](https://user-images.githubusercontent.com/22750208/123304008-194f4b80-d527-11eb-8663-0f90195b3f42.png)

## 4. Improvement Points
- Laravel File Cache used for caching. It could be replace for Redis cache for further requirements.

