<h1 align="center" id="title">laravel-hotel-management-backend</h1>

<p align="center" id="description"><strong>Webservice API for ERP System Multi-User for Hotel Management.</strong></p>

<p align="center">
  A modern and secure REST API designed to handle all aspects of hotel operations, including room bookings, reservations, and customer management.
</p>

---

## 🌟 Project Overview 

The **Hotely - Webservice API** is a comprehensive REST API built to manage hotel operations. It supports core functionalities such as:

- **Room Bookings & Reservations 🛏️:** Manage room availability and customer reservations.
- **Customer Management 👤:** Handle customer data and interactions.
- **Role-Based Access Control 🔐:** Secure user roles and permissions with Laravel Sanctum.
- **Secure Authentication & Authorization 🔑:** Ensure safe access control for different user roles.

---

## ⚙️ Technologies Used 

- **Backend 💻:** Laravel 11
- **Database 🗄️:** MySQL
- **Security 🔐:** Laravel Sanctum for authentication and authorization
- **API Documentation 📜:** Postman for endpoint documentation and testing

---

<h2>🗂️ ERD (Entity-Relationship Diagram)</h2>
<img width="100%" alt="db_hotel_erd" src="https://github.com/user-attachments/assets/9424d89a-b267-46d9-a296-e3718c3e07d6">

---

<h2>🌐 Api Endpoint</h2>

Here're some of the project's API Endpoint :

<br />

> [!NOTE]  
> * **Authentication**: Using Bearer token (JWT) for requests requiring authentication.

<br />

<h3>Authentication</h3>

| Endpoint                     | Method | Authentication Required | Description                                    | Request Body                                                                                  | Query Parameters |
|------------------------------|--------|-------------------------|------------------------------------------------|------------------------------------------------------------------------------------------------|-------------------|
| `/auth/login`                 | POST   | None                    | Login User                            | `{ "email": "admin@example.com", "password": "admin123" }`                                      | None              |
| `/auth/register-superadmin`   | POST   | Superadmin              | Register a new Superadmin                      | `{ "name": "Super Admin", "email": "superadmin@example.com", "password": "superadmin123" }`     | None              |
| `/auth/register-owner`        | POST   | Admin                   | Register a new Owner                          | `{ "name": "Owner", "email": "owner@example.com", "password": "owner123" }`                     | None              |
| `/auth/register-admin`        | POST   | Admin                   | Register a new Admin                          | `{ "name": "Admin New", "email": "adminNew@example.com", "password": "adminNew123" }`           | None              |
| `/auth/register-staff`        | POST   | Admin                   | Register a new Staff                          | `{ "name": "Staff", "email": "staff@example.com", "password": "staff123" }`                     | None              |
| `/auth/logout`                | POST   | Admin                   | Logout                                        | No body                                                                                         | None              |
<h3>User Management</h3>

| Endpoint                       | Method | Authentication Required | Description                                   | Request Body                                                                                                                                                         | Query Parameters |
|--------------------------------|--------|-------------------------|-----------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------|-------------------|
| `/users`                       | GET    | Superadmin               | Show all users                                | None                                                                                                                                                                 | `role=admin`, `page=1`, `size=10` |
| `/users/{userId}/permissions`  | PUT    | Admin                   | Edit permissions for a specific staff member | `{ "permissions": ["add_room", "view_room", "edit_room", "add_reservation", "view_reservation", "edit_reservation"] }`                                                | None              |


<h3>Hotel Management</h3>

| Endpoint                                | Method | Authentication Required | Description                                   | Request Body                                                                                                                                                                                                                 | Query Parameters |
|-----------------------------------------|--------|-------------------------|-----------------------------------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-------------------|
| `/hotels`                               | POST   | Owner                   | Add a new hotel                               | `{ "hotel_name": "Hotel Bahari1 x2222", "address": "Jl. Pantai No. 10, Bali", "description": "Hotel dengan pemandangan pantai yang indah.", "facilities": ["wifi", "kolam_renang", "restoran", "parkir"] }`                 | None              |
| `/hotels`                               | GET    | Superadmin               | Show all hotels suitable with id              | None                                                                                                                                                                                                                         | `status=denied`, `page=1`, `size=1` |
| `/hotels/{hotelId}/deny`                | PUT    | Superadmin               | Deny a hotel                                  | `{ "status_reason": "ditolak !" }`                                                                                                                                                                                     | None              |
| `/hotels/{hotelId}/approve`             | PUT    | Superadmin               | Approve a hotel                               | `{ "status_reason": "diterima !" }`                                                                                                                                                                                    | None              |
| `/hotels/{hotelId}/register-admin`      | PUT    | Owner                   | Register an admin for the hotel               | `{ "admin": [{ "id": 5, "name": "Admin User", "email": "admin@example.com" }] }`                                                                                                                                               | None              |
| `/hotels/{hotelId}/register-staff`      | PUT    | Admin                   | Register a staff member for the hotel         | `{ "staff": [{ "id": 3, "name": "Staff", "email": "staff@staff.com" }] }`                                                                                                                                                    | None              |

<h3>Room Management</h3>

| **Endpoint**                  | **Method** | **Authentication Required** | **Description**                                 | **Request Body**                                                                                                                                                     | **Query Parameters**              |
|-------------------------------|------------|-----------------------------|-------------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------------------------|
| `/rooms`                       | POST       | Staff        | Add a new room to the hotel                     | ```{"hotel_id": 1,"room_number": "1012","room_name": "Deluxe Room","capacity": 2,"price_per_night": 750000,"status": "available"}``` | None                              |
| `/rooms/hotel/{hotel_id}`      | GET        | Staff         | Show rooms for a specific hotel                 | None                                                                                                                                                                 | None    |
| `/rooms/{room_id}`             | PUT        | Staff         | Edit the details of an existing room            | ```{"room_name": "Deluxe Room 80","price_per_night": 80000}```                                                                                   | None                              |

<h3>Reservation Management</h3>

| **Endpoint**                    | **Method** | **Authentication Required** | **Description**                                 | **Request Body**                                                                                                                                                        | **Query Parameters**              |
|----------------------------------|------------|-----------------------------|-------------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------------------------|
| `/reservations`                  | POST       | Staff         | Add a new reservation for a room                | { "hotel_id": 1, "room_id": 1, "customer_name": "John Doe", "customer_email": "john.doe@example.com", "check_in": "2024-12-01 14:00:00", "check_out": "2024-12-05 12:00:00", "guest_count": 2, "total_amount": 500.00, "status_payment": "unpaid", "notes": "Late check-in requested" } | None                              |
| `/reservations`                  | GET        | Staff        | Show reservations by room and hotel ID          | None                                                                                                                                                                  | `hotel_id=1`, `room_id=1`, `page=1`, `size=10` |
| `/reservations/{reservation_id}` | PUT        | Staff        | Edit the reservation details by its ID          | { "status_payment": "partial", "notes": "Customer has pay 30%" }                                                                                                 | None                              |

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
