SypexGeo
==========

Sypex Geo - product for location by IP address.
Obtaining the IP address, Sypex Geo outputs information about the location of the visitor - country, region, city,
geographical coordinates and other in Russian and in English.
Sypex Geo use local compact binary database file and works very quickly.
For more information visit: http://sypexgeo.net/

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

```shell
composer require nuthouse-cis/sxgeo
```

Or add to your `composer.json` file.

```json
{
  "require": {
    "nuthouse-cis/sxgeo": "*"
  }
}
```

## Testing

* Unit tests:
```shell
  $ vendor/bin/phpunit
``` 
or 
```shell 
  composer run-script test
  ```
