## Todo
 
 [GitHub](http://github.com/mokgosi/loyalty-pwa)
 
 ## Installation Instructions
 
 The following instructions assumes that you are familiar with the necessary technologies required to carry out installation and that you have them already insalled in your machine.
 
 Based on: 
 * php 7.3.8
 * Laravel ^5.8
 * phpunit 7.5.9
 * mysql/mariadb 10.1.38-MariaDB
 * Vue 2.5.*
 
 
 ### Clone the repository:
 ```
 
 $ git clone git@github.com:mokgosi/loyalty-pwa.git
 
 ```
 
 ### Install dependencies
 ```
 
 $ composer update
 
 $ npm install
 
 ```
 
 composer require laravel/passport
 
 php artisan passport:install
 
 **Create .env and app key**
 
 ```
 
 $ cp .env.example .env
 $ php artisan key:generate
 
 ``` 
 
 **Update .env file with database name and credentials and other info**
 
 ```
 
 APP_NAME=App Name
 APP_URL=http://localhost:8000
 
 DB_DATABASE=dbname
 DB_USERNAME=username
 DB_PASSWORD=password
 
 ```


 ### Install voyager & passport
 ```
 
 $ php artisan migrate 

 $ php artsian voyager:install --with-dummy
 
 $ php artisan passport:install
 
 ```
 
 **Start your local server**
 ```
 
 $ cd to-your-project-root
 $ php artisan serve
 
 ```
 
 Browse to http://localhost:8000
 