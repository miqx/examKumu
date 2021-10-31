# Kumu Exam
Simple exercise from kumu.
## Requirements
 - Redis-server
 - MySql-server
 - Postman
 - PHP >= 7.3
 - Composer
 - Text Editor

## Installation
- run `composer install`.
- Copy `.env.example` and rename it to `.env`.
- Fill out fields on the `.env` file.
```env
DB_HOST={DATABASE HOST/IP}
DB_PORT={{DATABASE PORT}
DB_DATABASE={{DATABASE TO BE USED}
DB_USERNAME={{DATABASE USERNAME}
DB_PASSWORD={{DATABASE PASSWORD}

REDIS_HOST={REDIS HOST/IP}
REDIS_PASSWORD={REDIS PASSWORD}
REDIS_PORT={REDIS PORT}
```
 - run `php artisan migrate` to get table values.

## Usage

- ### User Creation
    - Using Postman send a POST request to `{host}/api/register-user` with these fields filled out.
    ```
        'name' => String, 
        'email' => String,
        'password' => String, 
        'password_confirmation' => String,
    ```
    - When you get a successful registration response you must copy/save the `API_TOKEN` from the response.
- ### API Usage
    - Using Postman send a GET request to `{host}/api/git/users` with these fields filled out.
    ```
            'user' => String (comma separated string of users), 
            'api_token' =>  String (api_token provided from registration)
    ```
- ### Token Recovery
    - Using Postman send a POST request to `{host}/api/get-token` with these fields filled out.
    ```
            'email' => String,
            'password' => String, 
    ```
