<?php

namespace YoungMayor\WebService\Response;

use GuzzleHttp\Psr7\Response;
use YoungMayor\WebService\Interfaces\ServiceResponse;

class SuccessResponse implements ServiceResponse
{
    public $response = null;

    public function __construct(?Response $response)
    {
        $this->response = $response;
    }

    public function render()
    {
        return [
            'status' => $this->getStatusCode(),
            'data' => $this->getBody(),
        ];
    }

    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }

    public function getBody()
    {
        return json_decode($this->response->getBody()->getContents(), true);
    }
}
