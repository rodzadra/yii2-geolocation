yii2-geolocation
================

Simple Yii2 component to find geo customer information.

[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com/)


### Installation


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist rodzadra/geolocation "*"
```

or add

```
"rodzadra/geolocation": "*"
```

to the require section of your `composer.json` file.

Configuration
---

1) In your config/main.php

```php

'components'=>[
    'geolocation' => [ 
        'class' => 'rodzadra\geolocation\Geolocation',
        'config' => [
            'provider' => 'freegeoip', //or 'geoplugin' (the default)
            'format' => 'php', //or 'json', 'xml' and 'json'(see below)
            'unserialize' => true, //(see below)
        ],
    ],
],

```function and just works on

### Config params

```php

provider: (string)

'geoplugin' or 'freegeoip; default to 'geoplugin';

(the return) format: (string)

For Geoplugin, you have 3 formats: 'php', 'json' or 'xml'; default to 'php'

For freegeoup, you have 3 formats: 'csv', 'json' or 'xml'; default to 'json'.

unserialize: (boolean)

This param make the use of the PHP unserialize() when using the 'php' format;

```

### How to use

On your view file.

```php

<?php
  print_r(yii::$app->geolocation->getClientInfoLocation());
?>

```
or

```php

<?php
  print_r(yii::$app->geolocation->getClientInfoLocation('173.194.118.22'));
?>

```
to find the geolocation from Google server.

### What you get?

Using the geoplugin provider:

```php
Array
(
    [geoplugin_request] => 173.194.118.22
    [geoplugin_status] => 200
    [geoplugin_credit] => Some of the returned data includes GeoLite data created by MaxMind, available from http://www.maxmind.com.
    [geoplugin_city] => Mountain View
    [geoplugin_region] => CA
    [geoplugin_areaCode] => 650
    [geoplugin_dmaCode] => 807
    [geoplugin_countryCode] => US
    [geoplugin_countryName] => United States
    [geoplugin_continentCode] => NA
    [geoplugin_latitude] => 37.419201
    [geoplugin_longitude] => -122.057404
    [geoplugin_regionCode] => CA
    [geoplugin_regionName] => California
    [geoplugin_currencyCode] => USD
    [geoplugin_currencySymbol] => $
    [geoplugin_currencySymbol_UTF8] => $
    [geoplugin_currencyConverter] => 1
)
```
For more information, please visit http://www.geoplugin.com/

Using the freegeoip provider:

```php

{
 "ip":"173.194.118.22",
 "country_code":"US",
 "country_name":"United States",
 "region_code":"CA",
 "region_name":"California",
 "city":"Mountain View",
 "zip_code":"94043",
 "time_zone":"America/Los_Angeles",
 "latitude":37.419,
 "longitude":-122.058,
 "metro_code":807
}

```
For more information, please visit https://freegeoip.net/
