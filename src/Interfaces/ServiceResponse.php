<?php

namespace YoungMayor\WebService\Interfaces;

interface ServiceResponse
{
    /**
     * Render the response to an array
     *
     * @return array
     */
    public function render();

    /**
     * Get the response status code
     *
     * @return int
     */
    public function getStatusCode();

    /**
     * Get the response body
     *
     * @return array|mixed
     */
    public function getBody();
}
