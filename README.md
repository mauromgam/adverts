# Adverts

####Objective
- Build an API that manages adverts, which could be used to retrieve and store information for a classifieds website such as www.vivastreet.co.uk or www.gumtree.com.
Please spend no more than 3 hours on this task.

####Languages & Technologies
PHP or NodeJS. There are no other tech limitations. Use whichever technology you need to use to achieve the objective.

####Data
You will have received CSV’s. This is the structure of the data and the data that you are to use in any way you see fit. You may use the CSV’s as the data source or import those somehow, that part is up to you.

####What is an advert?
Users post adverts in order to sell goods or services.

####Categories
Each advert is assigned to one category only. The categories are; pets, cars, and property.

####API capabilities
● Retrieve all categories
● Retrieve one category
● Retrieve one advert
● Retrieve all adverts
● Retrieve one user
● Retrieve a users latest advert
● Retrieve all of a users adverts

***

##Installation

* `composer install`
* `cp .env.example .env`
* `php artisan passport:install`
* Set up the database config in .env
* `php artisan migrate:fresh` 
  - optionally you can add the property `--seed` to seed the database after the tables were created 
* `php artisan serve`

***

####Run tests
vendor/bin/phpunit tests/

***

####Run import scripts in the specific order
* `php artisan csv:upload_categories categories.csv`
* `php artisan csv:upload_users users.csv`
* `php artisan csv:upload_adverts adverts.csv`

###### * The files `categories.csv`, `users.csv` and `adverts.csv` can be found in the directory \storage\files
