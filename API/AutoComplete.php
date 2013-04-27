<?php

/*
 * This file is part of the WeatherUndergroundBundle.
 *
 * (c) Nikolay Ivlev <nikolay.kotovsky@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Success\WeatherBundle\API;

use Buzz\Client\FileGetContents;
use Buzz\Message\Request as BuzzRequest;
use Buzz\Message\Response as BuzzResponse;

/**
 * Weather Underground Api AutoComplete
 * 
 * @author suncat2000 <nikolay.kotovsky@gmail.com>
 */
class AutoComplete
{
    private $apiKey;
    private $method;
    private $host;
    private $options;

    private $availOptions = array(
        'query',
        'format',
        'c',
        'h',
        'cities',
        'cb'
    );

    /**
     * Constructor
     * 
     * @param type $apiKey  Api key
     * @param type $format  Format
     * @param type $host    Host
     */
    public function __construct($apiKey, $format = 'json', $host = 'http://autocomplete.wunderground.com')
    {
        $this->apiKey = $apiKey;
        $this->host = $host;
        $this->options['format'] = $format;
        $this->method = 'GET';
    }

    /**
     * Set options
     * 
     * @param type $options 
     */
    public function setOptions(array $options)
    {
        if (count($options) == 0) {
            throw \Exception('Not set any options');
        }

        foreach ($options as $name => $value) {
            if (false === in_array($name, $this->availOptions)) {
                throw \Exception(sprintf('Option \'%s\' not available in API', $name));
            }

            $this->options[$name] = $value;
        }
    }

    /**
     * Get content format
     * 
     * @return type 
     */
    public function getFormat()
    {
        return $this->options['format'];
    }

    /**
     * Get data from api WU
     * 
     * @return SimpleXML|StdClass|false
     */
    public function getData()
    {
        $resource = $this->getDataResourse();

        $request = new BuzzRequest($this->method, $resource, $this->host);
        $response = new BuzzResponse();

        $client = new FileGetContents();

        // processing get data from WU API
        $attempt = 0;
        do {
            if ($attempt) {
                sleep($attempt);
            }

            try {
                $client->send($request, $response);
            } catch (\Exception $e) {
                continue;
            }
        } while (!($response instanceof BuzzResponse) && ++$attempt < 5);

        if (!($response instanceof BuzzResponse) || !$response->isOk()) {
            return false;
        }

        // parse data
        switch($this->getFormat()){
            case 'json':
                $data = json_decode($response->getContent());
                break;
            case 'xml':
                $data = simplexml_load_string($response->getContent());
                break;
            default :
                $data = false;
        }

        return $data;
    }

    /**
     * Get resource for Request
     * 
     * @return type 
     */
    protected function getDataResourse()
    {
        if (count($this->options) == 0) {
            throw \Exception("Don't set options! Use setOptions() method.");
        }

        return '/aq?' . http_build_query($this->options);
    }

}
