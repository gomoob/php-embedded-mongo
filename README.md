# php-embedded-mongo

> Start an embedded Mongo DB server and run your PHPUnit integration tests easily.

[![Total Downloads](https://img.shields.io/packagist/dt/gomoob/php-embedded-mongo.svg?style=flat)](https://packagist.org/packages/gomoob/php-embedded-mongo) 
[![Latest Stable Version](https://img.shields.io/packagist/v/gomoob/php-embedded-mongo.svg?style=flat)](https://packagist.org/packages/gomoob/php-embedded-mongo) 
[![Build Status](https://img.shields.io/travis/gomoob/php-embedded-mongo.svg?style=flat)](https://travis-ci.org/gomoob/php-embedded-mongo)
[![Coverage](https://img.shields.io/coveralls/gomoob/php-embedded-mongo.svg?style=flat)](https://coveralls.io/r/gomoob/php-embedded-mongo?branch=master)
[![Code Climate](https://img.shields.io/codeclimate/github/gomoob/php-embedded-mongo.svg?style=flat)](https://codeclimate.com/github/gomoob/php-embedded-mongo)
[![License](https://img.shields.io/packagist/l/gomoob/php-embedded-mongo.svg?style=flat)](https://packagist.org/packages/gomoob/php-embedded-mongo)

Writing integration tests using Mongo DB and PHP should be easy (it is in Java), this library allows you to quickly 
start an embedded Mongo DB server before running your tests.

## Install

The library starts a real Mongo DB server so you must have Java installed, then install the library using composer.

```
composer install --save-dev php-embedded-mongo
```

## Quick sample

```php

// Create and starts an embedded Mongo DB server
$mongoServer = new MongoServer();
$mongoServer->start();

...

// Execute your PHPUnit tests

...

// Stops ths embedded Mongo DB server
$mongoServer->stop();

```

Easy, isn't it ? 

## Notes

This library is not complete neither stable, if you want us to improve it feel free to post a Github issue. 

Here are important things to know about the behavior of the server : 
 * For now port numbers are not configurable, 2 ports are used `4309` and `27017` and must be free ; 
 * Port `27017` is used by the Mongo DB process (remember the library uses a real Mongo server) ; 
 * Port `4309` allows to send commands to a Java process which drives the Mongo DB process ; 
 * Log outputs location is not configurable, it default to `output.log`.
