<?php

namespace YoungMayor\WebService\Response;

use GuzzleHttp\Exception\RequestException;
use YoungMayor\WebService\Interfaces\ServiceResponse;

class ErrorResponse implements ServiceResponse
{
    protected $error = null;
    protected $response = null;

    public function __construct(?RequestException $error)
    {
        $this->error = $error;
        $this->response = $this->error->hasResponse() ? $this->error->getResponse() : null;
    }

    public function render()
    {
        return [
            'status' => $this->getStatusCode(),
            'message' => $this->getMessage(),
            'error' => $this->getBody(),
        ];
    }

    public function getStatusCode()
    {
        return $this->response ? $this->response->getStatusCode() : $this->error->getCode();
    }

    public function getBody()
    {
        return $this->response
            ? json_decode($this->response->getBody()->getContents(), true)
            : $this->error->getMessage();
    }

    public function getMessage()
    {
        return $this->error->getMessage();
    }
}
