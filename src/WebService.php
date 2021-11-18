<?php

namespace YoungMayor\WebService;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use InvalidArgumentException;

abstract class WebService
{
    protected $response;

    protected $client = null;

    protected $headers = [];

    public $response_status = 0;

    protected $timeout = 60;

    abstract protected function baseUri();

    public function __construct()
    {
        $this->client = new Client(array_merge(
            [
                'base_uri' => $this->baseUri(),
            ],
            $this->clientConfig()
        ));
    }

    public function makeRequest(string $method, string $uri, array $options = [])
    {
        $this->checkValidRequestMethod($method);
        if (!empty($this->headers)) {
            $options['headers'] = (!empty($options['headers']))
                ? array_merge($this->headers, $options['headers'])
                : $this->headers;
        }

        try {
            $this->response = $this->client->request(strtoupper($method), $uri, $options);
            return $this->renderResponse();
        } catch (RequestException $e) {
            return $this->renderExceptionResponse($e);
        }
    }

    protected function checkValidRequestMethod($method)
    {
        if (!$this->isValidRequestMethod($method)) {
            throw new InvalidArgumentException("{$method} is not a valid request type");
        }
    }

    protected function isValidRequestMethod($method)
    {
        $valid_methods = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'];

        return in_array(strtoupper($method), $valid_methods);
    }

    protected function clientConfig()
    {
        return ['timeout' => $this->timeout];
    }

    protected function setHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    protected function renderResponse()
    {
        $this->response_status = $this->response->getStatusCode();

        return [
            'status' => $this->response_status,
            'data' => json_decode($this->response->getBody()->getContents(), true),
        ];
    }

    public function renderExceptionResponse($exception)
    {
        $this->response = $exception->hasResponse() ? $exception->getResponse() : null;

        $this->response_status = $this->response ? $this->response->getStatusCode() : $exception->getCode();

        return [
            'status' => $this->response_status,
            'message' => $exception->getMessage(),
            'error' => $this->response ? json_decode($this->response->getBody()->getContents(), true) : $exception->getMessage(),
        ];
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function __call($method, $arguments)
    {
        $this->checkValidRequestMethod($method);

        return $this->makeRequest($method, ...$arguments);
    }
}
