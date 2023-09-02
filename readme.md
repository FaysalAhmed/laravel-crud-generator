# Laravel CRUD Generator

## Installation
First add the following on composer.json file  
```
"repositories": [
{
  "type":"git",
  "url": "git@github.com:FaysalAhmed/laravel-crud-generator.git"
}
]
```
After that, depends on your project status, either use  composer install or composer update   

Next, add the following on config/app.php 
```php
CRUDGeneratorServiceProvider::class
```
Now you can use the following command to create a CRUD resource 
```
php artisan generate:crud Product
```

This will create a Product CURD controller, model, validations, views. 
