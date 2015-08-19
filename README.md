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
            'provider' => '[PLUGIN_NAME]',
            'format' =>  '[SUPORTED_PLUGIN_FORMAT]',
            'api_key' => '[YOUR_API_KEY],
        ],
    ],
],

```

### Config params

```php

provider - The name of plugin to use (see examples on @vendor/rodzadra/geolocation/plugins/);

format - This is the return format supported by the plugin

api_key - If necessary, you can pass your api key here.

```

### Plugins

Plugins are simple PHP files, that returns an array with three vars:

- plugin_url : URL of webservice, with three special tags:

a) {{accepted_formats}}
b) {{ip}}
c) {{api_key}}

These tags will be replaced by their respective values.

- accepted_formats : An array with the return acceptable formats  (example ['csv', 'php', 'json', 'xml'])

- default_accepted_format : String with the default return format. (example "php")

### Plugin file example

```php
<?php

$plugin = [
            'plugin_url'                => 'http://www.geoplugin.net/{{accepted_formats}}.gp?ip={{ip}}',
            'accepted_formats'          => ['json', 'php', 'xml'],
            'default_accepted_format'   => 'php',
    ];

```


### How to use

In your view:

```php

<?php
  print_r(yii::$app->geolocation->getInfo());
?>

```

or, to find the geolocation infos from Google server, on your view.


```php

<?php
  print_r(yii::$app->geolocation->getInfo('173.194.118.22'));
?>

```

To change the plugin
--------------------


```php

<?php
    yii::$app->geolocation->getPlugin('ippycox','XML');
  print_r(yii::$app->geolocation->getInfo('173.194.118.22'));
?>

```


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

For another plugins infos, please use the sources. :)