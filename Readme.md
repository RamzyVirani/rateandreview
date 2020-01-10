# Rate And Review Module for the [Boilerplate](https://github.com/RamzyVirani/laravel-boilerplate)

Install this package with my boilerplate to add Rate and Review feature in your application. This module registers below components in the application. 

This module implements Laravel's polymorphic relations so that you can easily attach one or more models.


PS: This module is highly dependant on the [Boilerplate](https://github.com/RamzyVirani/laravel-boilerplate). Because this module extends some of the base classes Boilerplate has.


**General**

- Configuration
- Helper
- Migration
- Model
- Repository

**Admin**

- Controller
- Data Table
- Request Classes
- Routes
- Views

**API**
- Controllers
- Criteria
- Request Classes
- Routes

## How to install
Please make sure that you have completely installed the boilerplate including and most importantly executed the migration from the boilerplate.

Execute below command to add this package in your project's composer dependencies.
```
composer require ramzyvirani/rateandreview "*"
```

Execute below command to publish views and config
```
php artisan vendor:publish --tag=RamzyVirani\RateAndReview\RateAndReviewServiceProvider
```

Execute migrations to create Reviews Table, Module, Menu, Permissions

```
php artisan migrate
```

PS: You will need to login with Super Admin to grant permissions to the admin and other roles.


**How to Add Reviewable Options**

Follow below points to add reviewable options in Admin Panel's Create/Edit forms and also use human readable instance type in Index Details Views.

- Create a new Review Model in your application.
- Extend it from `RamzyVirani\RateAndReview\Models\Review`.
- Declare a public static property (array) named `$INSTANCE_TYPE` (E.g. in the original model).  
	- Use FQDN of the polymorphic relations as the key and Human readable text as value
- Change the fqdn in `config/rateandreview.php` 

## How to Extend Features

To Modify/Extend any functionality, Create a new class and extend it from the original Then, change the namespaces and fqdn in the `config/rateandreview.php`. Implement only those methods you want to modify.

- RamzyVirani\RateAndReview\Criteria\ReviewCriteria
- RamzyVirani\RateAndReview\DataTables\ReviewDataTable
- RamzyVirani\RateAndReview\Models\Review
- RamzyVirani\RateAndReview\Controllers\Admin\ReviewController
- RamzyVirani\RateAndReview\Controllers\Api\ReviewAPIController
- RamzyVirani\RateAndReview\Repositories\ReviewRepository