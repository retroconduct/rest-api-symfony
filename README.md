# Installation

create database called 'symfony'
git clone {this repo}
change directory to {this repo}
run php bin/console doctrine:schema:update --force to migrate the data structure
run php bin/console server:run

## Articles API

GET    /articles
GET    /articles/{id}
POST   /articles

author_id required integer
title     required string
url       required string
content   required string

PATCH  /articles/{id}

name required string

DELETE /articles/{id}

## Authors API

GET    /authors
GET    /authors/{id}
POST   /authors

name required string

PATCH  /authors/{id}
DELETE /authors/{id}

* instead of returning the name of the Author this returns the entire Author object