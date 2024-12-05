<h1 align="center" id="title">laravel-hotel-management-backend</h1>


<p align="center" id="description">Building an ERP System Multi-User for Hotel Management.</p>

<h2>🚀 Requirments</h2>

Here're some of the project's requirments :

Hierarki Tingkat Pengguna :
1. Superadmin
    * Menerima atau menolak pendaftaran hotel baru yang diajukan oleh Owner. ✔️
    * Melihat daftar semua hotel yang telah disetujui. ✔️
    * Melihat informasi pengguna di semua tingkat (Owner, Admin, dan Staff). ✔️
  
2. Owner
    * Login dan mendaftar. ✔️ 
    * Mengajukan pendaftaran hotel baru yang ingin dikelola. ✔️
    * Mendaftarkan Admin untuk hotel yang telah disetujui. ✔️
    * Melihat daftar hotel yang dimiliki dan informasi masing-masing Admin. ✔️
  
3. Admin
    * Login. ✔️
    * Mendaftarkan Staff untuk hotel yang dikelola. ✔️
    * Menetapkan Permission untuk Staff terhadap fitur tertentu. ✔️
    * Menamai Role tertentu dengan kombinasi Permission tertentu. ✔️
    * Melihat daftar Staff yang sudah didaftarkan untuk hotelnya. ✔️

4. Staff
    * Login. ✔️
    * Mengelola fitur tertentu berdasarkan Permission yang diberikan oleh Admin, 
    termasuk:

        *  Kelola kamar. ✔️
        *  Menetapkan harga kamar. ✔️
        *  Melakukan reservasi. ✔️
        *  elihat dan mencatat rekap pemasukan. ✔️


Deskripsi Fitur Sistem :
1. Pendaftaran Hotel Baru ✔️
* Aktor: Owner, Superadmin.
* Flow:
    1. Owner mengisi formulir pendaftaran hotel baru (nama hotel, alamat, deskripsi,
    fasilitas, dll.).
    2. Superadmin menerima notifikasi dan memutuskan untuk menerima atau
    menolak pendaftaran.
    3. Jika disetujui, hotel aktif dan Owner dapat mendaftarkan Admin.
    4. Jika ditolak, Owner mendapatkan notifikasi dengan alasan penolakan.
       
2. Manajemen User ✔️
* Aktor: Superadmin, Owner, Admin.
* Flow:
    1. Superadmin dapat melihat semua pengguna dan hotel dalam sistem.
    2. Owner dapat mendaftarkan Admin untuk hotel yang dimilikinya.
    3. Admin dapat mendaftarkan Staff dan menetapkan permissions mereka.

Tugas Pemrograman
* Buat desain basis data yang mencakup pengguna, hotel, kamar, reservasi,
roles, dan permissions.

* Implementasikan sistem login dan otorisasi berbasis roles dan permissions.
Bangun fitur CRUD untuk Superadmin, Owner, Admin, dan Staff sesuai hierarki
aksesnya.
Gunakan teknologi berikut:
    * Backend: Laravel 11 ✔️
    * Frontend: React.js dan Tailwind
    * Database: MySQL ✔️
    * API DOC: OpenApi / Postman ✔️
* Pengembangan Fitur dan Optimasi Code sangat direkomendasikan 

<br>
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
* Open Postman and Import for collections docs/Hotel Management.postman_collection.json
* Open Postman and Import for environments docs/Hotel Management.postman_environment.json


<h2>💻 Built with</h2>

Technologies used in the project :

*   MySql
*   Laravel 11
*   Laravel Sanctum
*   Postman
