A SOCIAL NETWORK PROJECT START POINT
====================================

This is a raw project of a social network server application. Migrations for the sample database schema is provided in the project. There are also authentication apis and a sample post upload api with the related controllers and repositories. File storing approach is ready for furthur usage.

Hope you enjoy the application :)

Getting Started
---------------

* Clone the repository
* Run `composer install`
* Modify `.env` file to configure connection to your local database
* Run `php artisan migrate`
* Run `php artisan scribe:generate`
* Access APIs documentation published in `/docs/index.html`
* Use `/api/auth/registration` endpoint to register in the application
* Use `/api/auth/login` endpoint to get your authentication token
* Enjoy developing the application :)


Documents
---------

Database Schema: https://github.com/morez-s/social-network/blob/master/docs/social_network.png <br />
Database Backup: https://github.com/morez-s/social-network/blob/master/docs/social_network.sql <br />
APIs Postman Collection: https://github.com/morez-s/social-network/blob/master/docs/Social%20Network.postman_collection.json
