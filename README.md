24irestAPI
==========
by:

Aimilia Kelaidi (aim.kelaidi@gmail.com)

## Getting Started

### Introduction

This application is rest api project built using PHP, Symfony 4 framework and a complete Docker stack. The API 
supports HTTP requests with HTTP verbs `GET`, `POST`, `PUT`, `DELETE` and an extra `POST` endpoint for uploading a file for database 
population.

For testing purposes, no `API KEY` is required. However, the endpoints use JWT Authentication and therefore can be used 
only after registering a user and receiving a JWT token.

The API offers the following operations:
* Operation 1
* Operation 2 etc.

### Installation

Just clone this repository with command:
```bash
    git clone https://github.com/aimikel/rest-24-api.git
```
Make sure you have Docker locally installed. Navigate into the working directory of the project and use commands:
```bash
    docker-compose build
```

```bash
    docker-compose up -d
```

The services built and run should be the following:
* `db`: a MySQL database instance
* `php-fpm`: initiated container with PHP
* `nginx`: an Nginx webserver instance

Extra Symfony bundles were added inside the `php-fpm` container after the initial setup was finished.
* Sensio annotations
* ORM pack for using doctrine ORM
* Symfony validator
* Uuid-doctrine package
* Json api bundle
* FOS User bundle for user management functionality
* Swift mailer service bundle
* Symfony translator service
* JWT Authentication bundle
* Gedmo doctrine extensions for Timestampable (among other field types)
* Symfony Maker Bundle
* phootwork/lang

* Note: Change `.env` file record in the Doctrine section with the right DB credentials as shown below:
`DATABASE_URL=mysql://symfony:symfony@db:3306/symfony?serverVersion=5.7`

Next, inside the php container, run the following commands:
```bash
    php bin/console make:migration
```

```bash
    php bin/console doctrine:migrations:migrate
```





