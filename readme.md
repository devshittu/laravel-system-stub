# Laravel System Stub
This is a project stub for any kind of **multi-actor** system written in Laravel php framework.
The procedure for use is as follow:
1. Fork this repo
2. Create and cd into a directory for another project name it as you wish.
3. Download and extract in to the new directory you've created.
4. From the terminal run the following commands

    
    1. composer install
    2. npm install / yarn
    3. cp .env.example .env
    4. php artisan key:generate
    5. Open .env and setup the database configuration that matches your server config.
    6. php artisan migrate:fresh --seed #setup database in ur env

all to be executed from cli