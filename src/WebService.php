<?php

namespace YoungMayor\WebService;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use InvalidArgumentException;

/**
 * Abstract WebService
 * 
 * @method string baseUri() Setup the base URI for all requests
 * @method array clientConfig() Setup the configurations to be sent with every request
 * @method null setHeaders(array $headers) Add headers to the list of headers sent with request. Call this before the request
 * 
 * @method \YoungMayor\WebService\ServiceResponse get(string $uri, array $options) Send a GET request to $uri with $options 
 * @method \YoungMayor\WebService\ServiceResponse post(string $uri, array $options) Send a POST request to $uri with $options
 * @method \YoungMayor\WebService\ServiceResponse put(string $uri, array $options) Send a PUT request to $uri with $options
 * @method \YoungMayor\WebService\ServiceResponse delete(string $uri, array $options) Send a DELETE request to $uri with $options
 * @method \YoungMayor\WebService\ServiceResponse patch(string $uri, array $options) Send a PATCH request to $uri with $options
 */
abstract class WebService
{
    protected $response;

    protected $client = null;

    protected $headers = [];

    protected $timeout = 60;

    /**
     * Set the base URI for the request
     *
     * @return string
     */
    abstract protected function baseUri();

    public function __construct()
    {
        $this->client = new Client(array_merge([
            'base_uri' => $this->baseUri(),
        ], $this->clientConfig()));
    }

    private function makeRequest(string $method, string $uri, array $options = [])
    {
        $this->checkValidRequestMethod($method);

        if (!empty($this->headers)) {
            $options['headers'] = (!empty($options['headers']))
                ? array_merge($this->headers, $options['headers'])
                : $this->headers;
        }

        try {
            $response = $this->client->request(strtoupper($method), $uri, $options);

            return new ServiceResponse($response);
        } catch (RequestException $e) {
            return new ServiceResponse(null, $e);
        }
    }

    private function checkValidRequestMethod($method)
    {
        if (!$this->isValidRequestMethod($method)) {
            throw new InvalidArgumentException("{$method} is not a valid request type");
        }
    }

    private function isValidRequestMethod($method)
    {
        $valid_methods = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'];

        return in_array(strtoupper($method), $valid_methods);
    }

    /**
     * Set the client's configuration sent with the request 
     *
     * @return void
     */
    protected function clientConfig()
    {
        return ['timeout' => $this->timeout];
    }

    protected function setHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    /**
     * Handle the request with the appropriate verb
     *
     * @param string $method
     * @param mixed $arguments
     * 
     * @return \YoungMayor\WebService\ServiceResponse
     */
    public function __call($method, $arguments)
    {
        $this->checkValidRequestMethod($method);

        return $this->makeRequest($method, ...$arguments);
    }
}
