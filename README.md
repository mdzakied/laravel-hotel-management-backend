<h1 align="center" id="title">laravel-hotel-management-backend</h1>


<p align="center" id="description">Building an ERP System Multi-User for Hotel Management.</p>


<h2>🧐 Features</h2>

Here're some of the project's best features :

*  Authentication and Authorization :
    * Registration Superadmin -> auth 'superadmin' role
    * Registration Owner -> public
    * Registration Admin -> auth 'owner' role
    * Registration Staff -> auth 'admin' role
    * Login User
    
*  CRUD Data :
    * Users
        * Get All User with Pagination -> auth 'superadmin' role
        * Edit permissions in staff role -> auth 'admin' role
        * Get User with Filter : -> auth 'superadmin' role
            * Role
            * Page
            * Size
    * Hotels
        * Add Hotel -> auth 'owner' role
        * Get All Hotel with Pagination -> auth (data hotel suitable with user) 
        * Get Hotel with Filter :
            * Status (pending, denied, approved)
            * Page
            * Size
        * Approve Hotel -> auth 'superadmin' role
        * Deny Hotel -> auth 'superadmin' role
        * Register Admin -> auth 'owner' role
        * Register Staff -> auth 'admin' role

    * Rooms 
        * Add Room ->  auth 'staff' role and permission 'add_room'
        * Get All Room by Hotel Id with Pagination -> auth 'staff' role and permission 'view_room' 
        * Edit Room by Id -> auth 'staff' role and permission 'edit_room'
     
    * Reservations 
        * Add Reservation ->  auth 'staff' role and permission 'add_reservation'
        * Get All Room by Room Id and Hotel Id with Pagination -> auth 'staff' role and permission 'view_reservation'
        * Edit Room by Id -> auth 'staff' role and permission 'edit_reservation'
  
<h2>🛠️ Installation Steps :</h2>

<p>1. Clone Repository</p>

```
git clone https://github.com/mdzakied/laravel-hotel-management-backend.git
```

<br />
<p>2. Prepare database (create db_hotel in mySql using xampp) and enable xampp </p>

<br />
<p>3. Complete configuration in file .env</p>

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_hotel
DB_USERNAME=root
DB_PASSWORD=
```

<br />
<p>4. Complete configuration in config/database.php</p>

```
        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'db_hotel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_general_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
```

<br />
<p>5. Run Command</p>

```
composer install
```
```
php artisan migrate:fresh
```
```
php artisan db:seed --class=SuperadminSeeder   
```

<br />
<p>6. Run Project for Development</p>

```
php artisan serve  
```

<h2>📃 Docs API</h2>
  
Postman :
* Run Project
* Open Postman and Import for collections
* Open Postman and Import for environments


<h2>💻 Built with</h2>

Technologies used in the project :

*   MySql
*   Laravel 11
*   Laravel Sanctum
*   Postman
