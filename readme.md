### How to run

# dependancies

```bash
npm i
composer install
```

# react.js frontend
```bash
npm start
```

# laravel backend

You will need to update the mysql database connection information in the .env file

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_schema
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

# how to start the server
```bash
php artisan migrate
php artisan serve
```