# Installation

create database called 'symfony'
```
git clone git@github.com:retroconduct/rest-api-symfony.git
```
change directory to 'rest-api-symfony' and run the following commands
```
php bin/console doctrine:schema:update --force
php bin/console server:run
```
Navigate to the following url and enjoy!
```
http://localhost:8000
```
## Articles API

- GET    /articles
- GET    /articles/{id}
- POST   /articles
author_id required integer
title     required string
url       required string
content   required string

- PATCH  /articles/{id}
author_id required integer
title     required string
url       required string
content   required string

- DELETE /articles/{id}

## Authors API

- GET    /authors
- GET    /authors/{id}
- POST   /authors
name required string

- PATCH  /authors/{id}
- DELETE /authors/{id}

#####   * instead of returning the name of the Author this returns the entire Author object