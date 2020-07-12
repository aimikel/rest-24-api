24irestAPI
==========
by:

Aimilia Kelaidi (aim.kelaidi@gmail.com)

## Getting Started

### Introduction

This application is rest api project built using PHP, Symfony 4 framework and a complete Docker stack. The API 
supports HTTP requests with HTTP verbs `GET`, `POST`, `PATCH`, `DELETE` and an extra `POST` endpoint for uploading a file for database 
population.

The endpoints use JWT Authentication and therefore they can be used only after registering a user and receiving a JWT token.

### Requirements

- Install [Docker](https://docs.docker.com/get-docker/)

---
### Installation

* Clone this repository with command:
```bash
    $ git clone https://github.com/aimikel/rest-24-api.git
```

* Add the record `127.0.0.1 symfony.localhost` into your hosts file.

* Note: If you want to change the database credentials, you need to change both environment variables for `db` service in `docker-compose.yml` and  `DATABASE_URL` in `symfony\.env` file accordingly before continuing to the next step.

* Next, run commands:
```bash
    $ docker-compose up -d
    $ docker exec -it php-fpm bash
    $ composer install
    $ php bin/console doctrine:migrations:migrate
    $ mkdir config/jwt
    $ openssl genrsa -out config/jwt/private.pem -aes256 4096
    $ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

---

### How to test
Use the following commands to run phpunit tests:

```bash
    $ docker exec -it php-fpm bash
    $ php bin/phpunit
```

### How to use

- First, make a `POST` call to endpoint `symfony.localhost/api/auth/register` with example json payload as below:

```
    {
    	"username":"testUsername",
    	"password":"testPassword", 
    	"email":"test@test.com"
    }
```

- Second, make a `POST` api call to endpoint `symfony.localhost/api/auth/login` with example json payload as below:

```
    {
        "username": "testUsername",
	"password": "testPassword"
    }
```
and grab the `JWT token` that is returned and include it in every endpoint call as an Authorization Bearer Token.

- Use the `symfony.localhost/assets/` endpoint to `POST` a single Asset to the database with example payload as below:

```
    {
        "data" : {
        		"type": "assets",
        		"attributes": {
        			"name": "testAsset",
        			"description": "demo description"
        		}
        	}
    }
```

Alternatively you can make batch Asset uploads to the database using the `POST` endpoint `symfony.localhost/files/` by uploading a csv file into key `file` of the body.
You can find a sample csv file inside the `symfony/exampleFiles` directory.

- Use the `GET` endpoint `symfony.localhost/assets/` to retrieve all existing Assets from the database.

- Use the `GET` endpoint `symfony.localhost/assets/ASSET_NAME` (as per requirement) to retrieve an existing Asset by name from the database.

- Use the `PATCH` endpoint `symfony.localhost/assets/ASSET_NAME` (as per requirement) to update an existing Asset by name in the database with example payload as below:

```
    {
        "data" : {
        		"type": "assets",
        		"id": "testAsset",
        		"attributes": {
        			"name": "testName222",
        			"description": "a simple description"
        		}
        	}
    }
```

- Use the `DELETE` endpoint `symfony.localhost/assets/ASSET_NAME` to remove an Asset from the database.

### To do

There are some more things that would need to be added for considering this app a full RESTful API and a well build application. I can see the following:

- `FileUpload` should ideally be seperated in two independent processes (eg. upload and parsing as a Queue)
- Configurable environment variables
- Caching mechanism for `GET` endpoint



