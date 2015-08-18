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
	],
],

```

### How to use

On your view file.

```php

<?php
  print_r(yii::$app->geolocation->getClientInfoLocation('173.194.118.22'));
?>

```