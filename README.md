# Attendance Management System

Attendance Management System(AMS) is a system used to manage the attendance of student/employee of a school/company.

# Description
AMS is a SAAS project. To register a company s/he must register in the system. After register your details in the system. Login into the system. After login into the system, create a company from the company option in the side bar. After creating company it send request to the superadmin. You can only add user and manage user only after the superadmin accept your company request.

## After creating company
1. Create role
2. Add user
3. Provider permission


## Installation

Use the [mailtrap](https://mailtrap.io/) to send email. Copy the mailtrap API and paste it into the mail section of .env file.


## Usage

```laravel
php artisan migrate

# create 'role'
php artisan db:seed RoleSeeder

#create 'superadmin'
php artisan db:seed SuperAdminSeeder

# login information
# email of superadmin => timilsinasagar04@gmail.com
# password of superadmin => 12345678

```

# CONTRIBUTORS
1. [Darshan KC](https://github.com/dkc1549)
2. [Sagar Timilsina](https://github.com/sagartimilsina)
3. [Aashish Paudel](https://github.com/aashishpaudel1122)
4. [Saroj Chhetri](https://github.com/sarojchhetri77)
