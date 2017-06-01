Fancy Frontend Application in PHP (FFAIP) (WIP)
========

Get Symfony started, add magento Host URL in parameters.yml
Add admin user credentials to parameters.yml

Prerequisite

* Magento Installation
* Admins User Credentials
* some Categories
* some Products

Installation

    composer install

    npm install

Configuration

Be sure that shop url, admin user and admin pass are set in parameters.yml:

![alt text](docs/images/parameters.jpg "parameters.yml")

Starting

After installation is done, simply run:

    php bin/console server:run

Application will be served on http://localhost:8000/

FE tasks:

Compile all javascript

    npm run build

Watch for javascript changes and rebuild stuff

    npm run watch
