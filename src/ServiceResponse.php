<?php

namespace YoungMayor\WebService;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use YoungMayor\WebService\Interfaces\ServiceResponse as InterfacesServiceResponse;
use YoungMayor\WebService\Response\ErrorResponse;
use YoungMayor\WebService\Response\SuccessResponse;

class ServiceResponse implements InterfacesServiceResponse
{
    protected $isError = false;
    protected $handler = null;

    public function __construct(Response $response = null, RequestException $error = null)
    {
        $this->isError = !is_null($error);

        $this->handler = $this->isError
            ? new ErrorResponse($error)
            : new SuccessResponse($response);
    }

    /**
     * Handle Response/Error when the request is completed
     *
     * @param function $onSuccess
     * @param function $onError
     * 
     * @return \YoungMayor\WebService\ServiceResponse
     */
    public function onComplete($onSuccess, $onError)
    {
        return $this->isError ?
            $onError($this->handler) :
            $onSuccess($this->handler);
    }

    public function render()
    {
        return $this->handler->render();
    }

    public function getStatusCode()
    {
        return $this->handler->getStatusCode();
    }

    public function getBody()
    {
        return $this->handler->getBody();
    }
}
