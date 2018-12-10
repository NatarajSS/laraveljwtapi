Installation

Follow the steps to install.

Step 1: git clone https://github.com/NatarajSS/laraveljwtapi.git

Step 2: cd laraveljwtapi (change to project directory)

Step 3: composer install

Step 4: create database laravelapi & update these database name & credentials in .env file in root folder 

Step 5: php artisan migrate

Step 6: php artisan serve
Visit 127.0.0.1:8000 to run the project

Instructions

Config the valid email(gmail) address and password in the .env file, bacause i have used smtp.gmail.com for mail send functionalities.

Routes:
 1. /register
 2. /login
 3. /users
 4. /update
 5. /avatar
 6. /profilepic
 
Register 
127.0.0.1:8000/register?name=raj&email=raj@gmail.com&mobileno=9988774455&password=123456789
Method : post

Login
127.0.0.1:8000/login?email=raj@gmail.com&password=1234567
Method : post

Users List
127.0.0.1:8000/users?Authorizationtoken={token_value}
Once logged in to the application you will get the Authorizationtoken value.
Method : get

Update User
127.0.0.1:8000/update?name=raj&email=raj@gmail.com&mobileno=9988774455&password=123456789&Authorizationtoken={token_value}
Method : post

Profile Picture Upload
127.0.0.1:8000/profilepic?image=selected_image&email=raj@gmail.com&Authorizationtoken={token_value}
Method : post







