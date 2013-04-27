<?php

namespace Success\WeatherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

  public function indexAction($country, $city, $lang) {
    $wuApi = $this->container->get('weather_underground.data_features');  
    $wuApi->setSettings(array('lang' => $lang));
    $wuApi->setFeatures(array('conditions', 'geolookup', 'forecast'));     // Features
    $wuApi->setQuery($country . '/' . $city, true);                 // Query
    $data = $wuApi->getData();

    return $this->render('SuccessWeatherBundle:Default:weather.html.twig', array('data' => $data));
  }

}
