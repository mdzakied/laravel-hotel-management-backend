<h1 align="center" id="title">laravel-hotel-management-backend</h1>

<p align="center" id="description"><strong>Webservice API for ERP System Multi-User for Hotel Management.</strong></p>

<p align="center">
  A modern and secure REST API designed to handle all aspects of hotel operations, including room bookings, reservations, and customer management.
</p>

---

## Project Overview 🌟

The **Hotely - Webservice API** is a comprehensive REST API built to manage hotel operations. It supports core functionalities such as:

- **Room Bookings & Reservations 🛏️:** Manage room availability and customer reservations.
- **Customer Management 👤:** Handle customer data and interactions.
- **Role-Based Access Control 🔐:** Secure user roles and permissions with Laravel Sanctum.
- **Secure Authentication & Authorization 🔑:** Ensure safe access control for different user roles.

---

## Technologies Used ⚙️

- **Backend:** Laravel 11
- **Database:** MySQL
- **Security:** Laravel Sanctum for authentication and authorization
- **Testing:** Postman for API testing and validation
- **API Documentation:** Postman for testing endpoints and generating API documentation

---

<h2>🗂️ ERD (Entity-Relationship Diagram)</h2>
<img width="100%" alt="db_hotel_erd" src="https://github.com/user-attachments/assets/9424d89a-b267-46d9-a296-e3718c3e07d6">

---

<h2>🌐 Api Endpoint</h2>

Here're some of the project's API Endpoint :

<br />

> [!NOTE]  
> * **Authentication**: Using Bearer token (JWT) for requests requiring authentication.
  
---

<h2>🛠️ Installation Steps </h2>

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

> [!NOTE]
> Information in command:
> * Superadmin account initialized (email: superadmin@superadmin.com, pass: password123)


<br />
<p>6. Run Project for Development</p>

```
php artisan serve  
```

<h2>📃 Docs API</h2>
  
Postman :
* Run Project
* Open Postman and Import for collections docs/Hotel Management.postman_collection.json
* Open Postman and Import for environments docs/Hotel Management.postman_environment.json
