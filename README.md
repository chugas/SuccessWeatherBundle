SuccessWeatherBundle
=============

Symfony2 bundle for working with Weather Underground API

Introduction
============

This Bundle enables integration [Weather Underground API](http://www.wunderground.com/weather/api/d/docs) with your Symfony 2 project.

Installation
============

### Add this bundle and kriswallsmith [Buzz](https://github.com/kriswallsmith/Buzz) library to `composer.json` in your project to `require` section:

````
...
TODO
...
````

### Add this bundle to your application's kernel:

````
//app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
            new Success\WeatherBundle\SuccessWeatherBundle(),
        // ...
    );
}
````

### Configure the `weather_underground` service in your YAML configuration:

````
#app/config/config.yml
weather_underground:
    apikey: your_api_key
````
### Full conﬁguration

````
#app/conﬁg/conﬁg.yml
success_weather:
    apikey: 02b04685c0db1361
    format: json                                                # json/xml
    host_data_features: http://api.wunderground.com             # default: http://api.wunderground.com
    host_autocomlete: http://autocomplete.wunderground.com      # default: http://autocomplete.wunderground.com
````

Usage example
============

### Data Features examples

``` php
    $wuApi->setRequestData(
        array('forecast', 'geolookup'),     // Features
        array('lang' => 'SP'),              // Settings
        'Russia/Moscow'                     // Query
    );
    $data = $wuApi->getData();
```

``` php
    $wuApi->setFeatures(array('forecast', 'geolookup'));     // Features
    $wuApi->setQuery('Uruguay/Montevideo', true);                 // Query
    $data = $wuApi->getData();
```

### AutoComplete example

``` php
    $wuAutocomplete = $this->getContainer()->get('weather_underground.autocomplete');
    $wuAutocomplete->setOptions(array('c' => 'RU', 'cities' => 1, 'query' => 'Mosc'));
    $data = $wuAutocomplete->getData();
```

Weather Underground API Documentation
============

[Data Features](http://www.wunderground.com/weather/api/d/docs?d=data/index)

[AutoComplete API](http://www.wunderground.com/weather/api/d/docs?d=autocomplete-api)

Source
============
Based on WeatherUndergroundBundle of suncat2000  (https://github.com/suncat2000/WeatherUndergroundBundle)
